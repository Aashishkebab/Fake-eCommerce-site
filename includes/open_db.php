<?php
    $servername = 'storedatabase.aashishbharadwaj.com';

    //For server
    /*$username = 'bharadwaj';
    $password = 'DRF3F';*/

    //For localhost
    /*$username = "root";
    $password = "";*/

    //For my server
    $username = "aashishkebab";
    $password = "qsxDrfv^#7";

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
