<?php
    $servername = 'localhost';

    //For server
    /*$username = 'bharadwaj';
    $password = 'DRF3F';*/

    //For localhost
    $username = 'Bharadwaj';
    $password = 'qsxdr^';

    $dbname = 'bharadwaj';

    try {
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        echo $error_message;
        exit();
    }
?>
