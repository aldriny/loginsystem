<?php
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
    private function isMatchPassword(){
        $hashedPwd = $this->matchPassword($this->email);
        return password_verify($this->pwd, $hashedPwd);
    }
    private function isValidCredentials(){
        return $this->validCredentials($this->email,$this->matchPassword($this->email));
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
        if ($this->isMatchPassword() == false) {
            $this->errors[] = "wrongEmailOrPassword";
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
        if (!empty($this->errors)) {
            $this->handleErrors($this->errors);
        }
    }
    public function login(){
        $this->validate();
    }

}