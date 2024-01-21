<?php
namespace Models;
use Config\Dbh;

Class EmailVerificationModel extends Dbh{
    protected function verifyEmail($token,$email){
        try {
            $pdo = $this->connect();
            $sql = 'UPDATE users SET verification_token=?,verification_sent_at=NOW() WHERE user_email = ?';
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$token,$email]);

        } catch (\PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            throw new \Exception("An error occurred while processing your request. Please try again later.");
        }
        }
        private function getToken($email){
            try {
                $pdo = $this->connect();
                $sql = 'SELECT verification_token from users WHERE user_email=?';
                $stmt = $pdo->prepare($sql);
                $stmt->execute([$email]);
                $result = $stmt->fetch();
                return $result['verification_token'];

            } catch (\PDOException $e) {
                error_log("Database error: " . $e->getMessage());
                throw new \Exception("An error occurred while processing your request. Please try again later.");
            }
            }  
    protected function confirmVerification($token,$email){
        try {
            if ($this->getToken($email) == $token) {
                $pdo = $this->connect();
                $sql = 'UPDATE users SET verified = ? WHERE user_email=? AND verification_token=?';
                $stmt = $pdo->prepare($sql);
                $stmt->execute([1,$email,$token]);
                if($stmt->rowCount() > 0){
                    return true;
                }
                else{
                    return false;
                }
            }
            else{
                error_log("Wrong Verification Code");
            }
        } catch (\PDOException $e) {
            error_log("Database error: " . $e->getMessage());
            throw new \Exception("An error occurred while processing your request. Please try again later.");
        }
        }  
    }
