<?php

declare(strict_types=1);

session_start();
require 'controller/index.php';

use Controller\Controller;

$testController = new Controller();

try {
    $action = filter_input(INPUT_GET, 'contact');

    if (isset($_GET['action'])) {
        if ($_GET['action'] === 'contact') {
            $testController->contact();
        }

        if ($_GET['action'] === 'login') {
            $testController->login();
        }

        if ($_GET['action'] === 'signup') {
            $testController->signup();
        }

        if ($_GET['action'] === 'logout') {
            $testController->logout();
        }

        if ($_GET['action'] === 'posts') {
            $testController->posts();
        }

        if ($_GET['action'] === 'myPosts') {
            $testController->myPosts();
        }

        if ($_GET['action'] === 'post') {
            $testController->post();
        }

        if ($_GET['action'] === 'postCreation') {
            $testController->postCreation();
        }

        if ($_GET['action'] === 'postEdition') {
            $testController->postEdition();
        }

        if ($_GET['action'] === 'postUpdate') {
            $testController->postUpdate();
        }

        if ($_GET['action'] === 'deletePost') {
            $testController->postDelete();
        }

        if ($_GET['action'] === 'commentCreation') {
            $testController->commentCreation();
        }

        if ($_GET['action'] === 'commentConfirmation') {
            $testController->commentConfirmation();
        }

        if ($_GET['action'] === 'deleteComment') {
            $testController->commentDelete();
        }

        if ($_GET['action'] === 'users') {
            $testController->users();
        }

        if ($_GET['action'] === 'user') {
            $testController->users();
        }
    } else {
        $testController->index();
    }
} catch (\Throwable) {
    //$testController->error();
}
