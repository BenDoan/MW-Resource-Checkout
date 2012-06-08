<?php
// Database constants needed to connect to DB
require_once('functions.php');
if (getBaseUrl() === "localhost") {
    define('DB_HOST','localhost');
    define('DB_NAME','resourcecheckout');
    define('DB_USERNAME','root');
    define('DB_PASSWORD','');
}else{
    require_once("production-db.php");
}
