<?php
    $servername = 'localhost';

    //For localhost
    $username = "root";
    $password = "";

    $dbname = 'fakestore';

    try {
        $db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    } catch (PDOException $e) {
        $error_message = $e->getMessage();
        echo "It no work!\n";
        echo $error_message;
        exit();
    }
?>
