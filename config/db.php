<?php
// Database constants needed to connect to DB
if ($_SERVER['SERVER_NAME'] === "localhost") {
    define('DB_HOST','localhost');
    define('DB_NAME','resourcecheckout');
    define('DB_USERNAME','root');
    define('DB_PASSWORD','');
}else{
    include("production-db.php");
}
