<?php
include("config.php");

if(!isset($_SESSION['email'])) {
    header("Location: ./");
    die;
}

if(isset($_POST['submit']))
{
    $qname = $_POST['qname'];
    $body = $_POST['body'];
    $skills = $_POST['skills'];
    if($qname == '')
    {
        $error = "Question name is required";
    }
    else if(strlen($qname)<3)
    {
        $error = "Question name character length minimum is 3.";
    }
    else if($body == '')
    {
        $error = "Question Body is required to be filled.";
    }
    else if(strlen($body)>500)
    {
        $error = "Question body must contain less than 500 characters";
    }
    else
    {
        $array = explode(",", $skills);
        $skils = serialize($array);

        $query = $pdo->prepare("INSERT INTO questions (name, body, skills, email) VALUES (:name, :body, :skills, :email)");
        $query->bindParam("name", $qname);
        $query->bindParam("body", $body);
        $query->bindParam("skills", $skils);
        $query->bindParam("email", $_SESSION['email']);
        $query->execute();

        $result = $query->rowCount();

        if($result > 0)
            $success = "Question has been submitted successfully!";
        else
            $error = "There is some error.";


    }
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset ="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Question Form</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<ul>
    <li><a href="questions.php">Questions</a></li>
    <li><a href="question.php" class="active">Add New Question</a></li>
    <li style="float:right"><a href="logout.php">Logout</a></li>
    <li style="float:right"><a><i>Logged in as <?php echo $_SESSION['fname'] ?> <?php echo $_SESSION['lname'] ?></i></a></li>
</ul>
<div class="container-div">
    <h1>Questions?</h1>
    <form method="post">
        <div class="container">

            <?php
            if(isset($error))
                echo "<p class='error'>Error: ".$error."</p>";

            else if(isset($success))
                echo "<p class='success'>Success: ".$success."</p>";
            ?>

            <label for="qname"><b>Question Name:</b></label>
            <input type="text" placeholder="Question Name" name="qname" id="qname" required>

            <label for="body"><b>Question Body:</b></label>
            <textarea name="body" id="body" placeholder="Body" rows="3"></textarea>

            <label for="skills"><b>Question Skills:</b></label>
            <input type="text" placeholder="Enter Skill" name="skills" id="skills" required>

            <button type="submit" name="submit">Submit</button>

        </div>
    </form>
</div>


</body>

</html>