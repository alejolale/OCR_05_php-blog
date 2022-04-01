<?php

//declare(strict_types=1);

namespace Controller;

use Session\Session;
use UserManager\UserManager;
use PublicationManager\PublicationManager;

require_once 'model/UserManager.php';
require_once 'model/PublicationManager.php';
require_once 'controller/Session.php';

class Controller
{
    private $userManager;
    private $publicationManager;

    public function __construct()
    {
        $this->userManager = new UserManager();
        $this->publicationManager = new PublicationManager();
    }

    public function index()
    {
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

        $title = filter_input(INPUT_POST, 'title');
        $header = filter_input(INPUT_POST, 'header');
        $content = filter_input(INPUT_POST, 'content');

        $posts =  $this->publicationManager->getPublications();


        if (isset($title) && isset($header) && isset($content)) {
            $userId = Session::get('USER_ID');

            //TODO create post
            $newPost = $this->publicationManager->createPublication($userId, $title, $header, $content);

            //TODO verify if
            if (isset($newPost)) {
                //TODO redirect to personal posts page
                $message = "Post crée avec succès!";
                $this->myPosts($message);
            } else {
                $message = "Erreur dans la création du post, veuillez reessayer";
                require('view/postsView.php');
            }

        } else {
            require('view/postsView.php');
        }
    }

    public function post()
    {
        $id = filter_input(INPUT_GET, 'id');

        if (isset($id)) {
            $user = $this->publicationManager->getPublication($id);

            if ($user) {
                require('view/postView.php');
            } else {
                $message = "La publication n'existe pas";
                $this->myPosts($message);
            }
        }
        //require('view/postsView.php');

        //require('view/postView.php');
    }

    public function myPosts($message)
    {
        $message;
        $userId = Session::get('USER_ID');
        $posts = $this->publicationManager->getPublicationsByUserId($userId);

        /*echo('<pre>');
        print_r($posts);
        echo('</pre>');*/

        //var_dump($posts);

        require('view/myPostsView.php');
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