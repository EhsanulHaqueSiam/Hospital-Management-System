<?php
$host = "127.0.0.1";
$dbname = "hospital_management";
$dbuser = "root";
$dbpass = "";

function getConnection(){
    global $host, $dbname, $dbuser, $dbpass;
    return mysqli_connect($host, $dbuser, $dbpass, $dbname);
}

class Database {
    private static $connection;
    
    public static function connect() {
        if (!self::$connection) {
            global $host, $dbname, $dbuser, $dbpass;
            self::$connection = mysqli_connect($host, $dbuser, $dbpass, $dbname);
            
            if (!self::$connection) {
                die("Database connection failed: " . mysqli_connect_error());
            }
        }
        return self::$connection;
    }
}
?>
