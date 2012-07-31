<?php
// Database constants needed to connect to DB
if ($_SERVER['SERVER_NAME'] === "localhost") {
    include("dev-db.php");
    error_reporting(E_ALL);
}else{
    include("production-db.php");
}
