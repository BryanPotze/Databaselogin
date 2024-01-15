<?php
$locatie = "mysql";
$databasenaam = "bugreporterdb";
$gebruikersnaam = "root";
$wachtwoord = "qwerty";

try{
    $db_handler = new PDO("mysql:host=$locatie;dbname=$databasenaam;charset=UTF8", $gebruikersnaam, $wachtwoord);
} catch(Exception $ex){
    print($ex);
}

function editEntry($frequency, $hardwareType, $os, $productName, $solution, $version, $id){
    global $db_handler;
    $stmt = $db_handler->prepare("
        UPDATE `bugreports`
        SET `Frequency` = :freq, `Hardware Type` = :hw, `OS` = :os, `Product Name` = :pn, `Solution` = :sl, `Version` = :vs
        WHERE id = :id
    ");

    $stmt -> bindParam("freq", $frequency, PDO::PARAM_STR);
    $stmt -> bindParam("hw", $hardwareType, PDO::PARAM_STR);
    $stmt -> bindParam("os", $os, PDO::PARAM_STR);
    $stmt -> bindParam("pn", $productName, PDO::PARAM_STR);
    $stmt -> bindParam("sl", $solution, PDO::PARAM_STR);
    $stmt -> bindParam("vs", $version, PDO::PARAM_INT);
    $stmt -> bindParam("id", $id, PDO::PARAM_INT);

    $stmt -> execute();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    editEntry($_POST["frequency"], $_POST["hardware_type"], $_POST["os"], $_POST["productName"], $_POST["solution"], $_POST["version"], $_POST["entry_id"]);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style.css">
        <title>Bug Reporter</title>
    </head>
    <body>
        <main>
            <table>
                <tr>
                    <th>Product Name</th>
                    <th>Version</th>
                    <th>Hardware Type</th>
                    <th>OS</th>
                    <th>Frequency</th>
                    <th>Solution</th>
                    <th>ID</th>
                    <th>Edit Link</th>
                </tr>
            <?php
                global $db_handler;
                $stmt = $db_handler->prepare("
                    SELECT *
                    FROM `bugreports`
                ");
                $stmt->execute();

                while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
                    echo "<tr>";
                    foreach ($result as $key => $value) {
                        echo "<td>$value</td>";
                    }
                    $id = $result["id"];
                    echo "<td><a href='edit_bugs.php?id=$id'>Edit</a> <a href='edit_bugs.php?id=$id&del=1'>Delete</a></td></tr>";
                }
            ?>
            </table>
            <a href="add_bugs.php">Add Bug</a>
        </main>
    </body>
</html>