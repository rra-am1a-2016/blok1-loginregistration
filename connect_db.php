<?php
    $servername = "localhost";
    $username = "rra_loginregis";
    $password = "geheim!";
    $dbname = "am1a_2016_loginregistration_v2";
    $conn = mysqli_connect($servername, $username, $password, $dbname) 
                or die("Connectie mislukt met databaseserver");
?>