<?php
include("config.php");

if(!isset($_SESSION['email'])) {
    header("Location: ./");
    die;
}

$query = $pdo->prepare("SELECT * FROM questions WHERE email = :email ");
$query->bindParam("email", $_SESSION['email']);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);


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
    <li><a href="questions.php" class="active">Questions</a></li>
    <li><a href="question.php">Add New Question</a></li>
    <li style="float:right"><a href="logout.php">Logout</a></li>
    <li style="float:right"><a><i>Logged in as <?php echo $_SESSION['fname'] ?> <?php echo $_SESSION['lname'] ?></i></a></li>
</ul>
<div class="questions-div">

    <table id="questions">
        <tr>
            <th>#</th>
            <th>Question Name</th>
            <th>Question Body</th>
            <th>Question Skills</th>
        </tr>
        <?php
        $i = 1;
        foreach($result as $q) { ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $q['name']; ?></td>
                <td><?php echo $q['body']; ?></td>
                <td><?php
                    $q['skills'] = unserialize($q['skills']);
                    foreach( $q['skills'] as $key => $sk) {
                        echo $sk;
                        if((count($q['skills']) - 1 ) != $key )
                            echo ", ";
                    }
                    ?></td>
            </tr>
            <?php
            $i++;
        } ?>

    </table>

</div>





</body>

</html>