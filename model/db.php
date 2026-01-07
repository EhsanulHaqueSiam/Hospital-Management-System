<?php

function getConnection()
{
    // Load configuration from XML
    $xml = simplexml_load_file('../config.xml');

    if ($xml === false) {
        die("Error: Cannot load configuration file");
    }

    $host = (string) $xml->database->host;
    $dbuser = (string) $xml->database->username;
    $dbpass = (string) $xml->database->password;
    $dbname = (string) $xml->database->dbname;

    $con = mysqli_connect($host, $dbuser, $dbpass, $dbname);

    if (!$con) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    return $con;
}

?>