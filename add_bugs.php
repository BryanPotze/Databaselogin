<?php
$locatie = "localhost";
$databasenaam = "bugreporterdb";
$gebruikersnaam = "root";
$wachtwoord = "qwerty";

try{
    $db_handler = new PDO("mysql:host=$locatie;dbname=$databasenaam;charset=UTF8", $gebruikersnaam, $wachtwoord);
} catch(Exception $ex){
    print($ex);
}

function addEntry($frequency, $hardwareType, $os, $productName, $solution, $version){
    global $db_handler;
    $stmt = $db_handler->prepare("
        INSERT INTO `bugreports` (`Frequency`, `Hardware Type`, `OS`, `Product Name`, `Solution`, `Version`) 
        VALUES (:freq , :hw, :os, :pn, :sl, :vs) 
    ");

    $stmt -> bindParam("freq", $frequency, PDO::PARAM_STR);
    $stmt -> bindParam("hw", $hardwareType, PDO::PARAM_STR);
    $stmt -> bindParam("os", $os, PDO::PARAM_STR);
    $stmt -> bindParam("pn", $productName, PDO::PARAM_STR);
    $stmt -> bindParam("sl", $solution, PDO::PARAM_STR);
    $stmt -> bindParam("vs", $version, PDO::PARAM_INT);

    $stmt -> execute();
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href=".//css/style.css">
        <title>Bug Reporter</title>
    </head>
    <body>
        <a href="index.php">&lt;&lt;&lt; Back</a>
        <br><br>
        <main>
            <form action="#" method="post" id="fill">
                <label for="productName">Product Name</label>
                <input type="text" name="productName" id="productName" required>
                <label for="version">Version</label>
                <input type="number" name="version" id="version" required>
                <label for="hardware_type">Hardware Type</label>
                <input type="text" name="hardware_type" id="hardware_type" required>
                <label for="os">OS</label>
                <input type="text" name="os" id="os" required>
                <label for="frequency">Frequency</label>
                <input type="text" name="frequency" id="frequency" required>
                <label for="solution">Solution</label>
                <input type="text" name="solution" id="solution" required>
                <br>
                <input type="submit" value="Add">
            </form>
        </main>
        <?php 
            if($_SERVER["REQUEST_METHOD"] == "POST"){
                echo "<p style='color:green;'>Succesfully added bug!</p>";
                addEntry($_POST["frequency"], $_POST["hardware_type"], $_POST["os"], $_POST["productName"], $_POST["solution"], $_POST["version"]);
            }
        ?>
    </body>
</html>