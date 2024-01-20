<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        if (isset($_GET['verification']) && $_GET['verification'] === 'success') {
            echo "Your Email was verfied successfully, please login";
        }
    ?>
    <h3>SIGN UP</h3>
    <form action="pages/signup.php" method="POST">
        <input type="email" name="email" placeholder=" Email Address"><br>
        <input type="text" name="firstName" placeholder=" First Name"><br>
        <input type="text" name="lastName" placeholder=" Last Name"><br>
        <input type="password" name="pwd" placeholder=" Password"><br>
        <input type="password" name="pwdRepeat" placeholder=" Repeat Password"><br>
        <button>Sign Up</button>
    </form>
    <?php
        if(isset($_GET['signupErrors'])){
            $signupErrors = $_GET['signupErrors'];
                echo "<p style='color: red'>" . $signupErrors[0] . "</p>";
        }
    ?>

    <h3>LOGIN</h3>
    <form action="pages/login.php" method="POST">
        <input type="email" name="email" placeholder=" Email Address"><br>
        <input type="password" name="pwd" placeholder=" Password"><br>
        <button>Login</button>
    </form>
    <?php
        if(isset($_GET['loginErrors'])){
            $loginErrors = $_GET['loginErrors'];
                echo "<p style='color: red'>" . $loginErrors[0] . "</p>";
            }
    ?>
</body>
</html>