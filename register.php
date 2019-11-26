<?php
include("config.php");
if(isset($_POST['submit']))
{
    $first_name = $_POST['fname'];
    $last_name = $_POST['lname'];
    $date = $_POST['date'];
    $email = $_POST['email'];
    $password = $_POST['pass'];
    if($first_name == '')
    {
        $error = "First Name is required";
    }
    else if($last_name == '')
    {
        $error = "Last name is required";
    }
    else if($date == '')
    {
        $error = "Please enter valid date";
    }
    else if($email == '')
    {
        $error = "Enter a valid email";
    }
    else if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        $error = "<b>$email</b> is not a valid email address";
    }
    else if($password == '')
    {
        $error = "Password is required";
    }
    else if(strlen($password)<8)
    {
        $error = "Minimum password length is 8 characters.";
    } else {

        $query = $pdo->prepare("SELECT COUNT(id) FROM users WHERE email = :email");
        $query->bindParam("email", $email);
        $query->execute();
        $exist = $query->fetchColumn();

        if($exist > 0){
            $error = "Email already exist in the database, you can login";
        } else {

            $query = $pdo->prepare("INSERT INTO users (fname, lname, dob, email, password) VALUES (:fname, :lname, :dob, :email, :password)");
            $query->bindParam("fname", $first_name);
            $query->bindParam("lname", $last_name);
            $query->bindParam("dob", $date);
            $query->bindParam("email", $email);
            $query->bindParam("password", $password);
            $query->execute();
            $result = $query->rowCount();

            if($result > 0){

                $success = "You have been registered successfully! You can login now";

            } else {
                $error = "There is some error.";
            }


        }

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset ="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <ul>
        <li><a href="./">Login</a></li>
        <li><a href="register.php" class="active">Register</a></li>
    </ul>
    <div class="container-div">
        <h1>Register:</h1>
        <form method="post">
            <div class="container">

                <?php
                    if(isset($error))
                        echo "<p class='error'>Error: ".$error."</p>";
                    else if(isset($success))
                        echo "<p class='success'>Success: ".$success."</p>";
                ?>

                <label for="fname"><b>First Name:</b></label>
                <input type="text" placeholder="Enter First Name" name="fname" id="fname" required>

                <label for="lname"><b>Last Name:</b></label>
                <input type="text" placeholder="Enter Last Name" name="lname" id="lname" required>

                <label for="date"><b>Date of Birth:</b></label>
                <input type="date" placeholder="Enter Date of Birth" name="date" id="date" required>

                <label for="email"><b>Email</b></label>
                <input type="email" placeholder="Enter Email" name="email" id="email" required>

                <label for="pass"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="pass" id="pass" required>

                <button type="submit" name="submit">Register</button>

            </div>
        </form>
    </div>

</body>
</html>