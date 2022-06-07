<?php

namespace Controller;

use Mailjet\Client;
use Mailjet\Resources;
use Session\Session;
use UserManager\UserManager;
use PublicationManager\PublicationManager;
use CommentManager\CommentManager;

require_once 'model/UserManager.php';
require_once 'model/PublicationManager.php';
require_once 'model/CommentManager.php';
require_once 'controller/Session.php';
require 'vendor/autoload.php';

class Controller
{
    private UserManager $userManager;
    private PublicationManager $publicationManager;
    private CommentManager $commentManager;

    public function __construct()
    {
        $this->userManager = new UserManager();
        $this->publicationManager = new PublicationManager();
        $this->commentManager = new CommentManager();
    }

    public function index(): void
    {
        $posts =  $this->publicationManager->getPublications(4);
        require('view/indexView.php');
    }

    public function login(): void
    {
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'password');
        $hasUser = false;
        $firstname = '';

        if (isset($email) && isset($password)) {
            $user = $this->userManager->login($email);
            $isValidPassword = password_verify($password, $user->password());
            $hasUser = $isValidPassword;

            if ($isValidPassword) {
                $email = $user->email();
                $userId = $user->id();
                $userType = $user->type();
                $firstname = $user->firstname();
                $confirmed = $user->confirmed();

                Session::put('LOGGED_USER', $email);
                Session::put('USER_ID', $userId);
                Session::put('USER_TYPE', $userType);
                Session::put('USER_CONFIRMED', $confirmed);
            } else {
                $message = "Le nom d'utilisateur ou le mot de passe est incorrect.";
            }
        }
        if (Session::get('LOGGED_USER')) {
            $message = "Vous êtes déjà connecté";
        }
        require('view/loginView.php');
    }

    public function logout(): void
    {
        session_destroy();
        header('Location: index.php');
    }

    public function signup(): void
    {
        $firstname = filter_input(INPUT_POST, 'firstname');
        $lastname = filter_input(INPUT_POST, 'lastname');
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'password');
        $passwordConfirmation = filter_input(INPUT_POST, 'passwordConfirmation');

        if (isset($firstname) && isset($lastname) && isset($email) && isset($password) && isset($passwordConfirmation)) {
            if ($password === $passwordConfirmation) {
                $req = $this->userManager->createUser($firstname, $lastname, $email, password_hash($password, PASSWORD_DEFAULT));
                if ($req === null) {
                    $message = 'Error, email existant!';
                } else {
                    $message = "Compte crée avec succès!, veuillez vous connecter!";
                }
            } else {
                $validationError = true;
                $message = "La validation du mot de passe est incorrect.";
            }
        }
        if (Session::get('LOGGED_USER')) {
            $message = "Vous êtes déjà connecté, vous pouvez créer un nouveau compte.";
        }
        require('view/signupView.php');
    }

    public function account(): void
    {
        $userId = Session::get('USER_ID');
        $userType = Session::get('USER_TYPE');
        if ($userId) {
            $user = $this->userManager->getUser($userId);
            $firstname = $user->firstname();
            $lastname = $user->lastname();
            require('view/accountView.php');
        } else {
            $this->index();
        }
    }

    public function accountEdition(): void
    {
        $userId = Session::get('USER_ID');
        $account = filter_input(INPUT_POST, 'account');
        $passwordEdition = filter_input(INPUT_POST, 'passwordEdition');


        if ($userId && $account) {
            $firstname = filter_input(INPUT_POST, 'firstname');
            $lastname = filter_input(INPUT_POST, 'lastname');
            $this->userManager->updateUser($userId, $firstname, $lastname);

            $message = 'Données modifiés avec succès !';
            require('view/accountView.php');
        } elseif ($userId && $passwordEdition) {
            $user = $this->userManager->getUser($userId);
            $firstname = $user->firstname();
            $lastname = $user->lastname();
            $currentPassword = $user->password();
            $password = filter_input(INPUT_POST, 'password');
            $newPassword = filter_input(INPUT_POST, 'new');
            $newPasswordConfirmation = filter_input(INPUT_POST, 'confirmation');

            $isValid = password_verify($password, $currentPassword) && $newPassword === $newPasswordConfirmation;

            if ($isValid) {
                $this->userManager->updatePassword($userId, password_hash($newPassword, PASSWORD_DEFAULT));
                $message = 'Mot de passe modifié avec succès !';
            } else {
                $message = 'Veuillez reesayer !';
            }
            require('view/accountView.php');
        } else {
            $this->account();
        }
    }

    public function posts()
    {
        $hasSession = Session::get('LOGGED_USER');
        $userId = Session::get('USER_ID');
        $confirmed = Session::get('USER_CONFIRMED');
        $user = $userId ? $this->userManager->getUser($userId) : null;

        $posts =  $this->publicationManager->getPublications();
        $myPosts = $this->publicationManager->getPublicationsByUserId($userId);
        $hasUserPosts = count($myPosts) > 0;

        if ($confirmed === 0) {
            $message = 'Veuillez attendre que votre compte soit validé pour publier, desormais vous pouvez lire et faire des commentaires sur les autres posts';
        }
        require('view/postsView.php');
    }

    public function post($message = null)
    {
        $hasSession = Session::get('LOGGED_USER');
        $id = filter_input(INPUT_GET, 'id');
        $edit = filter_input(INPUT_POST, 'edit');
        $message;

        if (isset($id)) {
            $userId = Session::get('USER_ID');
            $post = $this->publicationManager->getPublication($id);

            if ($post === null) {
                $message = "La publication n'existe pas";
                $this->myPosts($message);
            }

            $isCreator = $userId === $post->userId() || 'admin' === Session::get('USER_TYPE');
            $user = $userId ? $this->userManager->getUser($userId) : null;
            $comments = $this->commentManager->getComments($post->id());
            $disableComments = $this->commentManager->getDisabledComments($post->id());
            $action =  $edit ? '?action=post&id=' : '?action=postEdition&id=';

            $displayValidation = $hasSession && $isCreator && count($disableComments) > 0;

            require('view/postView.php');
        }
    }

    public function postCreation()
    {
        $hasSession = Session::get('LOGGED_USER');

        $title = filter_input(INPUT_POST, 'title');
        $header = filter_input(INPUT_POST, 'header');
        $content = filter_input(INPUT_POST, 'content');

        if (isset($hasSession) && isset($title) && isset($header) && isset($content)) {
            $userId = Session::get('USER_ID');
            $newPost = $this->publicationManager->createPublication($userId, $title, $header, $content);

            if (isset($newPost)) {
                //TODO redirect to personal posts page
                $message = "Post crée avec succès!";
                $this->myPosts($message);
            } else {
                $message = "Erreur dans la création du post, veuillez reessayer";
                require('view/postsView.php');
            }
        }
    }

    public function postEdition()
    {
        $hasSession = Session::get('LOGGED_USER');
        $id = filter_input(INPUT_GET, 'id');
        $edit = filter_input(INPUT_POST, 'edit');

        if (isset($id)) {
            $post = $this->publicationManager->getPublication($id);
            $comments = $this->commentManager->getComments($post->id());
            $disableComments = $this->commentManager->getDisabledComments($post->id());
            $userId = Session::get('USER_ID');
            $isVisible = $post->userId() === $userId;
            $action =  $edit ? '?action=post&id=' : '?action=postEdition&id=';
            $isCreator = $userId === $post->userId();
            $displayValidation = $hasSession && $isCreator && count($disableComments) > 0;

            if ($post) {
                require('view/postView.php');
            } else {
                $message = "La publication n'existe pas";
                $this->myPosts($message);
            }
        }
    }

    public function postUpdate()
    {
        $id = filter_input(INPUT_GET, 'id');
        $title = filter_input(INPUT_POST, 'title');
        $header = filter_input(INPUT_POST, 'header');
        $content = filter_input(INPUT_POST, 'content');

        if (isset($id) && isset($title) && isset($header) && isset($content)) {
            $this->publicationManager->updatePublication($id, $title, $header, $content);
            $this->post();
        } else {
            $message = "Erreur dans l'édition du post";
            $this->myPosts($message);
        }
    }

    public function postDelete(): void
    {
        $hasSession = Session::get('LOGGED_USER');
        $userId = Session::get('USER_ID');
        $postId = filter_input(INPUT_GET, 'id');
        $post = $this->publicationManager->getPublication($postId);

        $isDeletable = (int)$userId === $post->userId();

        if (isset($hasSession) && isset($postId) && $isDeletable) {
            $this->publicationManager->deletePublication($postId);
            $message = "Post supprimé avec succès!";
        } else {
            $message = "Une erreur s'est produit, veuillez re-essayer!";
        }
        $this->myPosts($message);
    }

    public function myPosts($message = null): void
    {
        $hasSession = Session::get('LOGGED_USER');
        $userId = Session::get('USER_ID');
        $posts = $this->publicationManager->getPublicationsByUserId($userId);

        if (isset($hasSession)) {
            require('view/myPostsView.php');
        } else {
            $this->posts();
        }
    }

    public function commentCreation()
    {
        $username = filter_input(INPUT_POST, 'user');
        $comment = filter_input(INPUT_POST, 'comment');
        $userId = filter_input(INPUT_POST, 'userId');
        $postId = filter_input(INPUT_GET, 'id');

        if (isset($username) && isset($comment) && isset($postId)) {
            $create = $this->commentManager->createComment($username, $comment, $postId, $userId);
            $message = $create ? 'Commentaire crée avec succès! en attente de validation...' :  "Une erreur s'est produite";
            $this->post($message);
        }
    }

    public function commentConfirmation()
    {
        $commentId = filter_input(INPUT_GET, 'commentId');

        if (isset($commentId)) {
            $this->commentManager->updateComment($commentId);
            $message = "Commentaire validé!";
        } else {
            $message = "Erreur dans la validation du commentaire";
        }
        $this->post($message);
    }

    public function commentDelete()
    {
        $hasSession = Session::get('LOGGED_USER');
        $commentId = filter_input(INPUT_GET, 'commentId');

        if (isset($commentId) && isset($hasSession)) {
            $this->commentManager->deleteComment($commentId);
            $message = "Commentaire supprimé avec succès!";
        } else {
            $message = "Une erreur s'est produit, veuillez re-essayer!";
        }
        $this->post($message);
    }

    public function contact()
    {
        $errors = [];
        $responseMessage = '';

        $firstname = htmlspecialchars(filter_input(INPUT_POST, 'firstname'));
        $lastname = htmlspecialchars(filter_input(INPUT_POST, 'lastname'));
        $email = htmlspecialchars(filter_input(INPUT_POST, 'email'));
        $message = htmlspecialchars(filter_input(INPUT_POST, 'message'));

        if (!empty($firstname || $lastname || $email || $message)) {
            if (empty($lastname)) {
                $errors[] = 'Lastname is empty';
            }

            if (empty($firstname)) {
                $errors[] = 'Firstname is empty';
            }

            if (empty($email)) {
                $errors[] = 'Email is empty';
            } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'Email is invalid';
            }

            if (empty($message)) {
                $errors[] = 'Message is empty';
            }

            if (empty($errors)) {
                $responseMessage =  '-';
                $toEmail = 'sergio@yieldstudio.fr';
                $emailSubject = 'New email from your contant form';

                $clientMessage = new Client('5e12f661454a2a6560005369c577f777', '23a96750389fb13b739362f54817de9f', true, ['version' => 'v3.1']);

                // Email to admin
                $body = [
                    'Messages' => [
                        [
                            'From' => [
                                'Email' => "sergio.prieto01@outlook.com",
                                'Name' => "Me"
                            ],
                            'To' => [
                                [
                                    'Email' => $toEmail,
                                    'Name' => "You"
                                ]
                            ],
                            'Subject' => "Blog || contact",
                            'TextPart' => "Greetings from Mailjet!",
                            'HTMLPart' => "<h3>Nouveau message de $firstname $lastname!</h3>
                                <br /><h4>Email : </h4>$email
                                <br /><h4>Message : </h4>$message"
                        ]
                    ]
                ];

                // transactional email to client
                $clientBody = [
                    'Messages' => [
                        [
                            'From' => [
                                'Email' => "sergio.prieto01@outlook.com",
                                'Name' => "ocr-bg-5"
                            ],
                            'To' => [
                                [
                                    'Email' => $email,
                                    'Name' => "Bonjour"
                                ]
                            ],
                            'TemplateID' => 3951237,
                            'TemplateLanguage' => true,
                            'Subject' => "ocr-bg-5",
                        ]
                    ]
                ];

                $response = $clientMessage->post(Resources::$Email, ['body' => $body]);
                $clientResponse = $clientMessage->post(Resources::$Email, ['body' => $clientBody]);

                if ($clientResponse->success() && $response->success()) {
                    $responseMessage = 'Données envoyées';
                } else {
                    $responseMessage = "Oops, Une erreur s'est produit, veuillez réessayer !";
                }
            } else {
                $responseMessage = 'Formulaire pas complet, Veuillez réessayer !';
            }
        }
        require('view/contactFormAnswer.php');
    }

    public function users(): void
    {
        $users = $this->userManager->getUsers();

        $id = filter_input(INPUT_GET, 'id');

        if (isset($id)) {
            $user = $this->userManager->getUser($id);
            $posts = $this->publicationManager->getPublicationsByUserId($id);
            require('view/userView.php');
        } else {
            require('view/usersView.php');
        }
    }

    public function userValidation(): void
    {
        $id = filter_input(INPUT_GET, 'id');

        if (isset($id)) {
            $this->userManager->userValidation($id);

            $message = "Utilisateur validé avec succès !!";
            require('view/userValidationView.php');
        } else {
            $message = "Une erreur s'est produit, veuillez re-essayer!";
            require('view/userValidationView.php');
        }
    }

    public function error()
    {
        require('view/errorView.php');
    }
}
