<?php
namespace Models;
use Config\Dbh;

class LoginModel extends Dbh{

    protected function matchPassword($email){
        $pdo = $this->connect();
        $sql = "SELECT user_password from Users WHERE user_email = ? ";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        return $result['user_password'];
    }

    protected function validCredentials($email,$pwd){
        $pdo = $this->connect();
        $sql = "SELECT user_email FROM Users WHERE user_email = ? && user_password = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email,$pwd]);
        $result = $stmt->fetch();
        return $result;
    }
}