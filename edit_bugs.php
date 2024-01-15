<?php
$locatie = "localhost";
$databasenaam = "bugreporterdb";
$gebruikersnaam = "Kees";
$wachtwoord = "Qwerty1234";

try{
    $db_handler = new PDO("mysql:host=$locatie;dbname=$databasenaam;charset=UTF8", $gebruikersnaam, $wachtwoord);
} catch(Exception $ex){
    print($ex);
}

function removeEntry($id){
    global $db_handler;
    $stmt = $db_handler->prepare("
        DELETE FROM `bugreports`
        WHERE id = :pkID
    ");

    $stmt-> bindParam("pkID", $id, PDO::PARAM_INT);

    $stmt-> execute();
}

if(!isset($_GET["id"])){
    header("Location: index.php");
}
elseif(isset($_GET["del"]) and $_GET["del"] == "1"){
    removeEntry($_GET["id"]);
    header("Location: index.php");
}
else{
    $id = $_GET["id"];
    $stmt = $db_handler->prepare("SELECT * FROM `bugreports` WHERE id = :id");
    $stmt->bindParam("id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $falseID = !($entryData = $stmt->fetch(PDO::FETCH_ASSOC));
    if($falseID){
        header("Location: index.php");
    }
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
            <form action="index.php" method="post">
                <label for="productName">Product Name</label>
                <input type="text" name="productName" id="productName" required value=<?php echo $entryData["Product Name"];?>>
                <label for="version">Version</label>
                <input type="number" name="version" id="version" required value=<?php echo $entryData["Version"];?>>
                <label for="hardware_type">Hardware Type</label>
                <input type="text" name="hardware_type" id="hardware_type" required value=<?php echo $entryData["Hardware Type"];?>>
                <label for="os">OS</label>
                <input type="text" name="os" id="os" required value=<?php echo $entryData["OS"];?>>
                <label for="frequency">Frequency</label>
                <input type="text" name="frequency" id="frequency" required value=<?php echo $entryData["Frequency"];?>>
                <label for="solution">Solution</label>
                <input type="text" name="solution" id="solution" required value=<?php echo $entryData["Solution"];?>>
                <label for="entry_id">ID</label>
                <input type="number" value=<?php echo $_GET["id"];?> disabled>
                <input type="hidden" name="entry_id" value=<?php echo $_GET["id"];?> >
                <br>
                <input type="submit" value="Save Changes">
            </form>
        </main>
    </body>
</html>