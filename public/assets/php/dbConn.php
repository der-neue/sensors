<?php
    /**
     * File: dbConn.php
     * Author: PreTooo
     * Date: 2021-05-01, 19:27:03
     */
    
    $dbHost = 'microhomeserver';
    $dbUser = 'sensor_user';
    $dbName = 'sensoren';
    $dbPass = 'sensor_user';

    $dbOptions = array(
        PDO::ATTR_PERSISTENT => true,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    );

    try {
        $dbHandler = new PDO('mysql:host='.$dbHost.';dbName='.$dbName, $dbUser, $dbPass, $dbOptions);
        $dbStmt = $dbHandler->prepare("USE `sensoren`");
        $dbStmt->execute();
    } catch (PDOException $e1) {
        var_dump('Verbindung zur Datenbank ist fehlgeschlagen! -> '.$e1->getMessage());
    }
?>