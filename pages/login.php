<?php
use Controllers\LoginController;
require_once __DIR__ . '/../vendor/autoload.php';

if (isset($_POST['email']) && isset($_POST['pwd'])) {
    $email = $_POST['email'];
    $pwd = $_POST['pwd']; 
    $login = new LoginController($email, $pwd);
    $login->login();
    echo "you're logged in as " . $email; 
}
