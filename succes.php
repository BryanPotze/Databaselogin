<?php
    session_start();
    if(!isset($_SESSION["username"])){
        header("location:index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Succes</title>
    </head>
    <body>
        <h1>Succesfully logged in</h1>
        <p>
        <?php
            $username = $_SESSION["username"];
            echo "Welcome, " . $username;
        ?>
        </p>
    </body>
</html>