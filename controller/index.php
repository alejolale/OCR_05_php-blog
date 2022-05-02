<?php

namespace Controller;

use Session\Session;
use UserManager\UserManager;
use PublicationManager\PublicationManager;
use CommentManager\CommentManager;

require_once 'model/UserManager.php';
require_once 'model/PublicationManager.php';
require_once 'model/CommentManager.php';
require_once 'controller/Session.php';

class Controller
{
    private $userManager;
    private $publicationManager;

    public function __construct()
    {
        $this->userManager = new UserManager();
        $this->publicationManager = new PublicationManager();
        $this->commentManager = new CommentManager();
    }

    public function index()
    {
        $posts =  $this->publicationManager->getPublications(4);
        require('view/indexView.php');
    }

    public function login()
    {
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'password');

        if (isset($email) && isset($password)) {
            //echo(password_hash($password, PASSWORD_DEFAULT));
            //TODO verify unhash
            //$user = $this->userManager->login($email, password_hash($password, PASSWORD_DEFAULT));
            $user = $this->userManager->login($email, $password);

            if ($user) {
                $email = $user->email();
                $userId = $user->id();
                /*echo('eyyy hre in login');
                var_dump($email);*/
                Session::put('LOGGED_USER', $email);
                Session::put('USER_ID', $userId);
                //TODO afficher vue une fois logé -- page posts
                $this->posts();
                //require('view/postsView.php');
                //header("Location: index.php");
            } else {
                $message = "Le nom d'utilisateur ou le mot de passe est incorrect.";
                require('view/loginView.php');
            }
        } else {
            require('view/loginView.php');
        }
    }

    public function logout()
    {
        session_destroy();
        header('Location: index.php');
    }

    public function signup()
    {
        $firstname = filter_input(INPUT_POST, 'firstname');
        $lastname = filter_input(INPUT_POST, 'lastname');
        $email = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'password');
        $passwordConfirmation = filter_input(INPUT_POST, 'passwordConfirmation');

        if (isset($firstname) && isset($lastname) && isset($email) && isset($password) && isset($passwordConfirmation)) {
            if ($password === $passwordConfirmation) {
                $this->userManager->createUser($firstname, $lastname, $email, password_hash($password, PASSWORD_DEFAULT));
                Session::put('LOGGED_USER', $email);
            } else {
                $validationError = true;
                $message = "La validation du mot de passe est incorrect.";
            }
        }

        require('view/signupView.php');
    }

    public function posts()
    {
        $hasSession = Session::get('LOGGED_USER');
        $posts =  $this->publicationManager->getPublications();

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

            $isCreator = $userId === $post->userId();
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
            /*if (isset($post)) {
            } else {
            }*/
        } else {
            $message = "Erreur dans l'édition du post";
            $this->myPosts($message);
        }
    }

    public function postDelete()
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

    public function myPosts($message)
    {
        $hasSession = Session::get('LOGGED_USER');
        $message;
        $userId = Session::get('USER_ID');
        $posts = $this->publicationManager->getPublicationsByUserId($userId);

        /*echo('<pre>');
        print_r($posts);
        echo('</pre>');*/
        //var_dump($posts);
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
        //TODO verify email sending
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
                $responseMessage =  'eooo';
                $toEmail = 'sergio.prieto01@outlook.com';
                $emailSubject = 'New email from your contant form';
                $headers = ['From' => $email, 'Reply-To' => $email, 'Content-type' => 'text/html; charset=iso-8859-1'];

                $bodyParagraphs = ["Nom: {$lastname}", "Prénom: {$firstname}", "Email: {$email}", "Message:", $message];
                $body = join(PHP_EOL, $bodyParagraphs);

                //TODO verify functionality
                $sendEmail = mail($toEmail, $emailSubject, $body, $headers);

                if ($sendEmail) {
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

    public function users()
    {
        $this->userManager = new UserManager();
        $users = $this->userManager->getUsers();

        $id = filter_input(INPUT_GET, 'id');

        if (isset($id)) {
            $user = $this->userManager->getUser($id);
            require('view/userView.php');
        } else {
            require('view/usersView.php');
        }
    }

    public function error()
    {
        require('view/errorView.php');
    }
}
