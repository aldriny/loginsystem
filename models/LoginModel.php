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
    protected function Verified($email){
        $pdo = $this->connect();
        $sql = "SELECT verified FROM Users WHERE user_email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        if($result['verified'] === 1){
            return true;
        }
        else{
            return false;
        }
    }
    protected function userId($email){
        $pdo = $this->connect();
        $sql = "SELECT id from Users WHERE user_email = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        return $result['id'];
    }
}