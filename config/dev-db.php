<?php
// Database constants needed to connect to DB
if ($_SERVER['SERVER_NAME'] === "localhost" || $_SERVER['SERVER_NAME'] === '192.168.1.2') {
    define('DB_HOST','localhost');
    define('DB_NAME','resourcecheckout');
    define('DB_USERNAME','root');
    define('DB_PASSWORD','');
}else{
    require_once("production-db.php");
}
