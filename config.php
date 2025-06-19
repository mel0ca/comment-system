<?php

    //host
    $host = "localhost"; 

    //db name
    $dbname = "auth-sys";

    //user
    $user = "root";

    //pass
    $pass = "";

     try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname;", $user, $pass);


        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        

     } catch (PDOException $e) {
         // Handle the connection error
         echo "Connection failed: " . $e->getMessage();

     }
?>