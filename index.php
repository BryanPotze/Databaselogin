<?php
    include_once("database.php");
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $stmt = $db_handler->prepare("SELECT passHash FROM accounts WHERE username = :username");
        $stmt->bindParam("username", $_POST["username"], PDO::PARAM_STR);
        $stmt->execute();
        $passHash = $stmt->fetch(PDO::FETCH_ASSOC)["passHash"];
        if($passHash and password_verify($_POST["pass"], $passHash)){
            session_start();
            $_SESSION["username"] = $_POST["username"];
            header("location:succes.php");
        }
        else{
            echo "<p style='color:red;'>Wrong password</p>";
        }
    }
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
    </head>
    <body>
        <h1>Login</h1>
        <form action="index.php" method="post" style="display:flex;flex-direction:column;width:20vw;gap:10px;">
            <label for="username">Username</label>
            <input type="text" name="username" id="username">
            <label for="pass">Password</label>
            <input type="password" name="pass" id="pass">
            <input type="submit" value="Login">
        </form>
        <a href="register.php">Create a new account</a>
    </body>
</html>