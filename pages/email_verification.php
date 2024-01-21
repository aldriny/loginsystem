<?php
use Controllers\EmailVerificationController;
require_once __DIR__ . '/../vendor/autoload.php';
session_start();
if (isset($_POST['otp'])) {
    $token = $_POST['otp'];
    $email = $_SESSION['user_email'];
    $verify = new EmailVerificationController();
    $verificationResult = $verify->verify($token,$email);
    if($verificationResult == true){
        if (isset($_SESSION['user_id'])) {
            $_SESSION['user_verified'] = true;
            header("location: login.php");
            exit();
        }
        header("location: ../index.php?verification=success");
        exit();
    }
    else{
        echo "Wrong verification code";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
</head>
<body>
    <form action="email_verification.php" method="post">
        <label>Enter Verfication Code: </label>
        <input type="text" name="otp" placeholder=" Verfication Code">
        <button>Verify Email</button>
    </form>
</body>
</html>