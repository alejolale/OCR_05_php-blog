<?php

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
        $toEmail = 'sergio@yieldstudio.fr';
        $emailSubject = 'New email from your contant form';
        $headers = ['From' => $email, 'Reply-To' => $email, 'Content-type' => 'text/html; charset=iso-8859-1'];

        $bodyParagraphs = ["Nom: {$lastname}", "Prénom: {$firstname}", "Email: {$email}", "Message:", $message];
        $body = join(PHP_EOL, $bodyParagraphs);

        if (mail($toEmail, $emailSubject, $body, $headers)) {
            $responseMessage = 'Données envoyées';
        } else {
            $responseMessage = "Oops, Une erreur s'est produit, veuillez réessayer !";
            $errors[] = "Erreur d'envoi d'email";
        }
    }else {
        $responseMessage = 'Formulaire pas complet, Veuillez réessayer !';
    }
}