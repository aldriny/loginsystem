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
            return !empty($this->email) && !empty($this->firstName) && !empty($this->lastName) && !empty($this->pwd) && !empty($this->pwdRepeat);  
          //  $this->errors[] = "emptyInputs";
    }
    private function isValidEmail(){
        return filter_var($this->email,FILTER_VALIDATE_EMAIL);
          //  $this->errors[] = "invalidEmail";
    }
    private function isValidName(){
        $pattern = '/^(?=.{1,15}$)[A-Za-z]+(?:[\' -][A-Za-z]+)?$/';
        return preg_match($pattern, $this->firstName) || !preg_match($pattern, $this->lastName);
           // $this->errors[] = "invalidName";
    }
    private function isValidPassword(){
        $pattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/';
        return preg_match($pattern, $this->pwd);
          //  $this->errors[] = "invalidPassword";
        
    }
    private function isValidPasswordMatch(){
        return $this->pwd === $this->pwdRepeat;
         //   $this->errors[] = "invalidPasswordMatch";
    }
    private function isEmailUnique(){
        return $this->uniqueEmail($this->email);
           // $this->errors[] = "emailAlreadyTaken";
    }
    private function handleErrors($errors){     
        $errorString = implode("&",array_map(function($error){
            return "signupErrors[]=" . urlencode($error);
        },$errors));
        header("location: ../index.php?" . $errorString);
        exit();
    }
    private function validate(){
        if ($this->emptyInputs() == false){
            $this->errors[] = "emptyInputs";
        }
        if ($this->isValidEmail() == false){
            $this->errors[] = "invalidEmail";
        }
        if ($this->isValidName() == false){
            $this->errors[] = "invalidName";
        }
        if ($this->isValidPassword() == false){
            $this->errors[] = "invalidPassword";
        }
        if ($this->isValidPasswordMatch() == false){
            $this->errors[] = "invalidPasswordMatch";
        }
        if ($this->isEmailUnique() == false){
            $this->errors[] = "emailAlreadyTaken";
        }
        if (!empty($this->errors)){
            $this->handleErrors($this->errors);
        }

    }

    public function signUp(){
        $this->validate();
        $hashedPwd = password_hash($this->pwd, PASSWORD_DEFAULT);
        $this->addUser($this->email,$this->firstName,$this->lastName,$hashedPwd);
    }


}