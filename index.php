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

        if ($_GET['action'] === 'post') {
            $testController->post();
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
