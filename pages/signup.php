<?php

    include '../includes/autoloader.php';

    $email = $_POST['email'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $pwd = $_POST['pwd'];
    $pwdRepeat = $_POST['pwdRepeat'];

    $addUser = new SignupController($email,$firstName,$lastName,$pwd, $pwdRepeat);
    $addUser->signUp();
