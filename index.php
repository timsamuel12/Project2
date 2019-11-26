<?php
include("config.php");

{
    $email = $_POST['fname'];
    $pass = $_POST['pass'];

    if($email == '')
    {
        $error= "Email is required";
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $error = "<b>$email</b> is not a valid email address";
    }
    else if($pass == '')
    {
        $error = "Password is required";
    }
    else if(strlen($pass)<8)
    {
        $error = "Minimum password length is 8";
    } else {

        $query = $pdo->prepare("SELECT fname, lname FROM users WHERE email = :email AND password = :password ");
        $query->bindParam("email", $email);
        $query->bindParam("password", $pass);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);

        if(false == $result) {
            $error = "Email or password is incorrect";
        } else {

            $_SESSION['email'] = $email;
            $_SESSION['fname'] = $result['fname'];
            $_SESSION['lname'] = $result['lname'];

            header("Location: questions.php");

            die;
        }




    }
}

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset ="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In Form</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
<ul>
    <li><a href="./" class="active">Login</a></li>
    <li><a href="register.php">Register</a></li>
</ul>
<div class="container-div">
    <h1>Login</h1>
    <form method="post">
        <div class="container">

            <?php
            if(isset($error))
            {
                echo "<p class='error'>Error: ".$error."</p>";
            }
            ?>

            <label for="fname"><b>Email</b></label>
            <input type="email" placeholder="Enter Email" name="fname" id="fname" required>

            <label for="pass"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="pass" id="pass" required>

            <button type="submit" name="submit">Login</button>

        </div>
    </form>
</div>

</body>
