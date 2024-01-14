<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="pages/signup.php" method="POST">
        <input type="email" name="email" placeholder=" Email Address">
        <input type="text" name="firstName" placeholder=" First Name">
        <input type="text" name="lastName" placeholder=" Last Name">
        <input type="password" name="pwd" placeholder=" Password">
        <input type="password" name="pwdRepeat" placeholder=" Repeat Password">
        <button>Sign Up</button>
    </form>
    <?php
        if(isset($_GET['signupErrors'])){
            $signupErrors = $_GET['signupErrors'];
            foreach ($signupErrors as $error){
                echo "<p style='color: red'>" . $error . "</p>";
            }
        }
    ?>
</body>
</html>