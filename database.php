<?php
    $locatie = "mysql";
    $databasenaam = "logindb";
    $gebruikersnaam = "kees";
    $wachtwoord = "Qwerty1234";

    try{
        $db_handler = new PDO("mysql:host=$locatie;dbname=$databasenaam;charset=UTF8", $gebruikersnaam, $wachtwoord);
    } catch(Exception $ex){
        print($ex);
    }
?>