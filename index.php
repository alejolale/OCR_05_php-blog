<?php
session_start();
require('controller/index.php');

$testController = New Controller();

try {
    if (isset($_GET['action'])) {
        if ($_GET['action']=== 'contact') {
            $testController->contact();
        }
        if ($_GET['action']=== 'login') {
            $testController->login();
        }
        if ($_GET['action']=== 'signup') {
            $testController->signup();
        }
        if ($_GET['action']=== 'logout') {
            $testController->logout();
        }
        if ($_GET['action']=== 'users') {
            $testController->users();
        }if ($_GET['action']=== 'user') {
            $testController->users();
        }
    }
    else {
        $testController->index();
    }
}
catch (Exception $error) {
    $testController->error();
}
