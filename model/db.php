<?php

function getConnection()
{
    $host = "127.0.0.1";
    $dbname = "hospital_db";
    $dbuser = "root";
    $dbpass = "";

    $con = mysqli_connect($host, $dbuser, $dbpass, $dbname);

    if (!$con) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    return $con;
}

?>