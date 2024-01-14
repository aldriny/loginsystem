<?php
Class SignupModel extends Dbh {
    protected function uniqueEmail($email){
        $pdo = $this->connect();
        $sql = 'SELECT * FROM Users WHERE user_email = ?';
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
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            throw new Exception("Database error: " . $e->getMessage());
        }
        
       
    }

}