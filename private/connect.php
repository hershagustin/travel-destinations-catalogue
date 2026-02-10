<?php 

// define("DB_SERVER", "localhost");
// define("DB_USER", "root");
// define("DB_PASS", "");
// define("DB_NAME", "php");
define("DB_SERVER", "localhost");
define("DB_USER", "odo21787");
define("DB_PASS", "connect321aha?");
define("DB_NAME", "odo21787_php");

function db_connect() {
    $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    } else {
        return $connection;
    }
}

function db_disconnect($connection) {
    if(isset($connection)) {
        mysqli_close($connection);
    }
}

?>