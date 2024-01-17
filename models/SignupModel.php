<?php
namespace Models;
use Config\Dbh;
Class SignupModel extends Dbh {
    protected function uniqueEmail($email){
        $pdo = $this->connect();
        $sql = 'SELECT user_email FROM Users WHERE user_email = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        return !$result;
    }
    protected function addUser($email,$firstName,$lastName,$pwd){
        try {
            $pdo = $this->connect();
            $sql = 'INSERT INTO Users (user_email,user_firstName,user_lastName,user_password) VALUES (?,?,?,?)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$email,$firstName,$lastName,$pwd]);
            if ($stmt->rowCount() > 0) {
                return true;
            }
            else{
                error_log("User addition failed, no rows affected");
            }
        } catch (\PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            throw new \Exception("An error occurred while processing your request. Please try again later.");
        }
        
       
    }

}