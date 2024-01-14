<?php
class SignupController extends SignupModel{
    private $email;
    private $firstName;
    private $lastName;
    private $pwd;
    private $pwdRepeat;
    private $errors = [];

    public function __construct($email,$firstName,$lastName,$pwd, $pwdRepeat)
    {
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->pwd = $pwd;
        $this->pwdRepeat = $pwdRepeat;
    }
    private function emptyInputs(){
        if(empty($this->email) || empty($this->firstName) || empty($this->lastName) || empty($this->pwd) || empty($this->pwdRepeat)){
            $this->errors[] = "emptyInputs";
        }
    }
    private function isValidEmail(){
        if(!filter_var($this->email,FILTER_VALIDATE_EMAIL)){
            $this->errors[] = "invalidEmail";
        }
    }
    private function isValidName(){
        $pattern = '/^(?=.{1,15}$)[A-Za-z]+(?:[\' -][A-Za-z]+)?$/';
        if(!preg_match($pattern, $this->firstName) || !preg_match($this->lastName, $pattern)){
            $this->errors[] = "invalidName";
        }
    }
    private function isValidPassword(){
        $pattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
        if(!preg_match($pattern, $this->pwd)){
            $this->errors[] = "invalidPassword";
        }
    }
    private function isValidPasswordMatch(){
        if($this->pwd !== $this->pwdRepeat){
            $this->errors[] = "invalidPasswordMatch";
        }
    }
    private function isEmailUnique(){
        $result = $this->checkEmailExist($this->email);
        if ($result == false) {
            $this->errors[] = "emailAlreadyTaken";
        }
    }

    public function signUp(){
        if (empty($this->errors)){
            $hashedPwd = password_hash($this->pwd, PASSWORD_DEFAULT);
            $this->addUser($this->email,$this->firstName,$this->lastName,$hashedPwd);
        }
        else{
            echo "Error: " . $this->errors[0];
        }
    }


}