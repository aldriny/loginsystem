<?php
class SignupController extends SignupModel{
    private $email;
    private $firstName;
    private $lastName;
    private $pwd;
    private $pwdMatch;
    private $errors = [];

    public function __construct($email,$firstName,$lastName,$pwd, $pwdMatch)
    {
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->pwd = $pwd;
        $this->pwdMatch = $pwdMatch;
    }
    public function emptyInputs(){
        if(empty($this->email) || empty($this->firstName) || empty($this->lastName) || empty($this->pwd) || empty($this->pwdMatch)){
            $this->errors[] = "emptyInputs";
        }
    }
    public function isValidEmail(){
        if(!filter_var($this->email,FILTER_VALIDATE_EMAIL)){
            $this->errors[] = "invalidEmail";
        }
    }
    public function isValidName(){
        $pattern = '/^(?=.{1,15}$)[A-Za-z]+(?:[\' -][A-Za-z]+)?$/';
        if(!preg_match($pattern, $this->firstName) || !preg_match($this->lastName, $pattern)){
            $this->errors[] = "invalidName";
        }
    }
    public function isValidPassword(){
        $pattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
        if(!preg_match($pattern, $this->pwd)){
            $this->errors[] = "invalidPassword";
        }
    }
    public function isValidPasswordMatch(){
        if($this->pwd !== $this->pwdMatch){
            $this->errors[] = "invalidPasswordMatch";
        }
    }
    public function isEmailUnique(){
        $result = $this->checkEmailExist($this->email);
        if ($result == false) {
            $this->errors[] = "emailAlreadyTaken";
        }
    }

    public function signUp(){
        if (empty($this->errors)){
            $hashedPwd = password_hash($this->pwd, PASSWORD_DEFAULT);
            $addUser = $this->addUser($this->email,$this->firstName,$this->lastName,$hashedPwd);
        }
    }


}