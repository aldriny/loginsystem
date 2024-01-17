<?php
namespace Config;
class Dbh {
    private $host = "localhost";
    private $dbname = "project";
    private $username = "root";
    private $password = "";

    protected function connect(){
        $dsn = "mysql:host=$this->host;dbname=$this->dbname";
    try {
        $pdo = new \PDO($dsn, $this->username, $this->password);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE,\PDO::FETCH_ASSOC);
        return $pdo;
    } catch (\PDOException $e) {
        header("HTTP/1.1 500 Internal Server Error");
        error_log("Error connecting to the database: $this->dbname" . $e->getMessage());
        die("An internal server error occurred. Please try again later.");
    }
    }
}