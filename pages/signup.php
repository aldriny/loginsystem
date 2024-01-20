<?php
    use Controllers\SignupController;
    use Controllers\EmailVerificationController;

    require_once __DIR__ . '/../vendor/autoload.php';

    session_start();

    $email = $_POST['email'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $pwd = $_POST['pwd'];
    $pwdRepeat = $_POST['pwdRepeat'];

    $addUser = new SignupController($email,$firstName,$lastName,$pwd, $pwdRepeat);
    $addUser->signUp();
    
    $_SESSION['email'] = $email;
    $verifyEmail = new EmailVerificationController();
    $verifyEmail->sendEmail($email);

    header("location: email_verification.php");
    exit();