<?php
namespace Controllers;
use Models\LoginModel;
class LoginController extends LoginModel{
    private $email;
    private $pwd;
    private $errors = [];

    public function __construct($email, $pwd)
    {
        $this->email = $email;
        $this->pwd = $pwd;
    }
    
    private function emptyInputs(){
        return !empty($this->email)&& !empty($this->pwd);  
    }
    private function isValidEmail(){
        return filter_var($this->email,FILTER_VALIDATE_EMAIL);
    }
    private function isValidPassword(){
        $pattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
        return preg_match($pattern, $this->pwd);
    }
    private function isValidCredentials(){
        $hashedPwd = $this->matchPassword($this->email);
        return password_verify($this->pwd, $hashedPwd);
    }
    private function isVerified(){
        return $this->Verified($this->email);
    }
    private function startLoginSession(){
        if ($this->isValidCredentials()){
            $id = $this->userId($this->email);
            $_SESSION['user_id'] = $id;
            $_SESSION['user_email']= $this->email;
            if (!$this->isVerified()) {
                header("location: ../Pages/email_verification.php");
                exit();
            }
        }
    }
    private function handleErrors($errors){
        $errorString = implode("&", array_map(function ($error){
            return "loginErrors[]=" . urlencode($error);
        },$errors));
        header("location: ../index.php?" . $errorString);
        exit();
    }

    public function validate(){
        if ($this->emptyInputs() == false) {
            $this->errors[] = "emptyInputs";
        }
        if ($this->isValidEmail() == false) {
            $this->errors[] = "invalidEmail";
        }
        if ($this->isValidPassword() == false) {
            $this->errors[] = "invalidPassword";
        }
        if ($this->isValidCredentials() == false) {
            $this->errors[] = "invalidCredentials";
        }
        if ($this->isVerified() == false) {
            $this->errors[] = "notVerfied";
            $this->startLoginSession();
        }
        if (!empty($this->errors)) {
            $this->handleErrors($this->errors);
        }
    }
    public function login(){
        $this->validate();
        $this->startLoginSession();

    }

}