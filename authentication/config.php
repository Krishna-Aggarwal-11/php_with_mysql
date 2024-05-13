<?php

    $host = "localhost";
    $user = "root";
    $password = "";
    $database = "authentication";

    $conn = new PDO("mysql:host=$host;dbname=$database", $user, $password);

    if ($conn == true) {
        echo "Connected";
    }else{
        echo "Not Connected";
    }
?>