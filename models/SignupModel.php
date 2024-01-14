<?php
Class SignupModel extends Dbh {
    public function checkEmailExist($email){
        $pdo = $this->connect();
        $sql = 'SELECT * FROM Users WHERE user_email = ?;';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email]);
        $result = $stmt->fetch();
        if($result){
            return true;
        }
        else{
            return false;
        }
    }
    public function addUser($email,$firstName,$lastName,$pwd){
        try {
            $pdo = $this->connect();
            $sql = 'INSERT INTO Users (user_email,user_firstName,user_lastName,user_password) VALUES (?,?,?,?);';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$email,$firstName,$lastName,$pwd]);
            if ($stmt->rowCount() > 0) {
                return true;
            }
            else{
                return false;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        
       
    }

}