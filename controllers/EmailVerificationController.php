<?php
namespace Controllers;
use Models\EmailVerificationModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class EmailVerificationController extends EmailVerificationModel{
    public function sendEmail($to){
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;
            $mail->isSMTP();
            $mail->Host = $_ENV['SMTP_HOST'];
            $mail->SMTPAuth = true;
            $mail->Username = $_ENV['USER_NAME'];
            $mail->Password = $_ENV['PASSWORD'];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = $_ENV['SMTP_PORT'];
            //Recipients
            $mail->setFrom($_ENV['USER_NAME'],"Muhammad Aldriny");
            $mail->addAddress($to);
            //Content
            $token = random_int(100000, 999999);
            $mail->Subject = 'Email Verification';
            $mail->Body = "Your verification code is $token";
            $this->verifyEmail($token,$to);
            $mail->send();

            echo "Verification Email has been sent successfully, Please check your email.";
        } catch (Exception $e) {
            error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            echo "Verification Email could not be sent. Try again later.";
        }
    }
    public function verify($token,$email){
        return $this->confirmVerification($token,$email);
    }
}