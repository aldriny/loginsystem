<?php
use Controllers\LoginController;
include "../includes/autoloader.php";

$email = $_POST['email'];
$pwd = $_POST['pwd'];

$login = new LoginController($email, $pwd);
$login->login();

echo "you're logged in as " . $email;