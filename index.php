<?php

    include_once("database.php");
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        try{
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
        }catch(Exception $ex){
            echo $ex;
        }
    }
?>

<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href=".//css/style.css">
        </head>
    <body>
        <div class="center">
    <form class="form" action="index.php" method="post">
  <div class="title">Welcome,<br><span>sign up to continue</span></div>
  <input type="text" name="username" id="username"class="input" placeholder="Username">
  <input type="password" placeholder="Password" name="password" class="input">
  <div class="login-with">
  </div>
  <input type="submit" value="Login"class="button-confirm"></input>
  <button type="button" class="button-confirm_new" onclick="window.location.href='register.php'">New account</button>

</form>
</div>
    </body>
</html>