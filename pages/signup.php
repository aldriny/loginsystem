<?php
    use Controllers\SignupController;
    use Controllers\EmailVerificationController;

    require_once __DIR__ . '/../vendor/autoload.php';

    session_start();

    if(isset($_GET['email']) && isset($_GET['firstName']) && isset($_GET['lastName']) && isset($_GET['pwd']) && isset($_GET['pwdRepeat'])){
        $email = $_POST['email'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $pwd = $_POST['pwd'];
        $pwdRepeat = $_POST['pwdRepeat'];
    
        $addUser = new SignupController($email,$firstName,$lastName,$pwd, $pwdRepeat);
        $addUser->signUp();
        
        if (isset($_SESSION['email'])) {
            $_SESSION['email'] = $email;
            $verifyEmail = new EmailVerificationController();
            $verifyEmail->sendEmail($email);  
            header("location: email_verification.php");
            exit();
        }
    }
