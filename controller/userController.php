<?php
$userManager = new UserManager();
$users = $userManager->getUsers();

if (isset($_GET['id'])) {
    $user = $userManager->getUser($_GET['id']);
}
