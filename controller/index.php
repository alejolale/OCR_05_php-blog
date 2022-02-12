<?php
require_once('model/UserManager.php');

class Controller {
    private $userManager;

    public function __construct()
    {
        $this->userManager = New UserManager();
    }

    public function index(){
        require('view/indexView.php');
    }

    public function login() {
        if (isset($_POST['email']) && isset($_POST['password'])) {
            $user = $this->userManager->login($_POST['email'], $_POST['password']);

            if ($user) {
                var_dump($user);
                $_SESSION['LOGGED_USER']= $user->email();
                //TODO afficher vue une fois logé -- page posts
            }
            //vue error
            /*else {
                $message = "Le nom d'utilisateur ou le mot de passe est incorrect.";
            }*/
        } else {
            require('view/loginView.php');
        }
    }

    public  function logout() {
        session_destroy();
        header('Location: index.php');
    }

    public function signup() {
        if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['passwordConfirmation'])) {

            if($_POST['password'] === $_POST['passwordConfirmation']) {

                //var_dump('hello world',$_POST['password'], password_hash($_POST['password'], PASSWORD_DEFAULT) );
                $user = $this->userManager->createUser($_POST['firstname'], $_POST['lastname'], $_POST['email'], password_hash($_POST['password'], PASSWORD_DEFAULT));
                var_dump($user);
                //$_SESSION['LOGGED_USER']= $user->email();
            }else {
                $passwordValidationError= true;
                $message = "La validation du mot de passe est incorrect.";
            }
        }

        require('view/signupView.php');
    }

    public function contact() {
        //TODO verify email sending
        $errors = [];
        $responseMessage = '';

        if (!empty($_POST)) {
            $lastname = htmlspecialchars($_POST['lastname']);
            $firstname = htmlspecialchars($_POST['firstname']);
            $email = htmlspecialchars($_POST['email']);
            $message = htmlspecialchars($_POST['message']);

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

                $sendEmail= mail($toEmail, $emailSubject, $body, $headers);
                if ($sendEmail) {
                    $responseMessage = 'Données envoyées';
                } else {
                    $responseMessage = "Oops, Une erreur s'est produit, veuillez réessayer !";
                }
            }else {
                $responseMessage = 'Formulaire pas complet, Veuillez réessayer !';
            }
        }

        require('view/contactFormAnswer.php');
    }

    public function users(){
        $this->userManager = new UserManager();
        $users = $this->userManager->getUsers();

        if (isset($_GET['id'])) {
            $user = $this->userManager->getUser($_GET['id']);
            require('view/userView.php');
        }else {
            require('view/usersView.php');
        }
    }

    public function error() {
        require('view/errorView.php');
    }

}