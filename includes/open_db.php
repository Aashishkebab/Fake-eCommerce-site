<?php
    $servername = 'localhost';

    //For localhost
    $username = 'root';
    $password = '';

    $dbname = 'bharadwaj';

    try {
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        echo $error_message;
        exit();
    }
?>
