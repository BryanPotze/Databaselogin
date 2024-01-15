<?php
    include_once("database.php");
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
        <h1>Register</h1>
        <form action="register.php" method="post" class="form">
            <label for="username">Username</label>
            <input type="text" name="username" id="username"class="input">
            <label for="e-mail">E-mail</label>
            <input type="email" name="e-mail" id="e-mail"class="input">
            <label for="pass">Password</label>
            <input type="password" name="pass" id="pass"class="input">
            <label for="passRepeat">Repeat Password</label>
            <input type="password" name="passRepeat" id="passRepeat">
            <input type="submit" value="Create Account">
        </form>
        <a href="index.php">Log in to existing account</a>

        <?php
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                filter_var($_POST["e-mail"], FILTER_VALIDATE_EMAIL);
                if($_POST["pass"] == $_POST["passRepeat"]){
                    try{
                        $stmt = $db_handler->prepare("INSERT INTO accounts (username, email, passHash)
                                                      VALUES (:username, :email, :passHash)");

                        $passHash = password_hash($_POST["pass"], PASSWORD_BCRYPT);
                        $stmt->bindParam("username", $_POST["username"], PDO::PARAM_STR);
                        $stmt->bindParam("email", $_POST["e-mail"], PDO::PARAM_STR);
                        $stmt->bindParam("passHash", $passHash, PDO::PARAM_STR);
    
                        $stmt->execute();

                        $email = $_POST["e-mail"];
                        echo "<p style='color:green;'>Account Created for $email</p>";
                    }
                    catch(Exception $ex){
                        print($ex);
                    }
                }
                else{
                    echo "<p style='color:red;'>Wrong repeated password</p>";
                }
            }
        ?>
    </body>
</html>