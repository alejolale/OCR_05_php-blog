<?php

declare(strict_types=1);

session_start();
require 'controller/index.php';

use Controller\Controller;

$controller = new Controller();

try {
    $action = filter_input(INPUT_GET, 'contact');

    if (isset($_GET['action'])) {
        if ($_GET['action'] === 'contact') {
            $controller->contact();
        }

        if ($_GET['action'] === 'login') {
            $controller->login();
        }

        if ($_GET['action'] === 'signup') {
            $controller->signup();
        }

        if ($_GET['action'] === 'account') {
            $controller->account();
        }

        if ($_GET['action'] === 'accountEdition') {
            $controller->accountEdition();
        }

        if ($_GET['action'] === 'logout') {
            $controller->logout();
        }

        if ($_GET['action'] === 'posts') {
            $controller->posts();
        }

        if ($_GET['action'] === 'myPosts') {
            $controller->myPosts();
        }

        if ($_GET['action'] === 'post') {
            $controller->post();
        }

        if ($_GET['action'] === 'postCreation') {
            $controller->postCreation();
        }

        if ($_GET['action'] === 'postEdition') {
            $controller->postEdition();
        }

        if ($_GET['action'] === 'postUpdate') {
            $controller->postUpdate();
        }

        if ($_GET['action'] === 'deletePost') {
            $controller->postDelete();
        }

        if ($_GET['action'] === 'commentCreation') {
            $controller->commentCreation();
        }

        if ($_GET['action'] === 'commentConfirmation') {
            $controller->commentConfirmation();
        }

        if ($_GET['action'] === 'deleteComment') {
            $controller->commentDelete();
        }

        if ($_GET['action'] === 'users') {
            $controller->users();
        }

        if ($_GET['action'] === 'userValidation') {
            $controller->userValidation();
        }

        if ($_GET['action'] === 'user') {
            $controller->users();
        }
    } else {
        $controller->index();
    }
} catch (\Throwable) {
    //$testController->error();
}
