<?php
use Controllers\LoginController;
require_once __DIR__ . '/../vendor/autoload.php';
session_start();

if(isset($_SESSION['user_id'])){
    $email = $_SESSION['user_email'];
    echo "You're logged in as " . $email;
}
else if (isset($_POST['email']) && isset($_POST['pwd'])) {
    $email = $_POST['email'];
    $pwd = $_POST['pwd']; 
    $login = new LoginController($email, $pwd);
    $login->login();
    echo "you're logged in as " . $email; 
}
?>

<form action="logout.php" method="post">
    <button>logout</button>
</form>
