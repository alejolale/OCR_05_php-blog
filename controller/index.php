<?php
require_once('model/UserManager.php');

function index() {
    require('view/indexView.php');
}

function login() {
    require('view/loginView.php');
}

function contact() {
    require('contactController.php');
    require('view/contactFormAnswer.php');
}

function users() {
    require('userController.php');
    require('view/usersView.php');
}

function user($id) {
    require('userController.php');
    require('view/userView.php');
}