<?php

//returns the resource identifer matching the resource id param
function getResourceDesc($id){
    $conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
    $sql = "SELECT * FROM resources WHERE resource_id={$id}";
    $results = $conn->query($sql);

    $resource_description = null;
    while($row = $results->fetch_assoc()){
        $resource_description = $row['resource_identifier'];
    }
    return $resource_description;
}

//returns the username matching the id param
function getUsername($id){
    $conn = new mysqli('localhost',DB_USERNAME,DB_PASSWORD,DB_NAME);
    $sql = "SELECT * FROM users WHERE user_id=$id";
    $results = $conn->query($sql);

    $username = "";
    while($row = $results->fetch_assoc()){
            $username = $row['user_username'];
    }
    $conn->close();
    return $username;
}

//writes $line to the log file
function writeLineToLog($line){
    $logFile = "logFile.txt";
    $fh = fopen($logFile, 'a') or die("can't open file");
    $line .= "\n";
    fwrite($fh, $line);
    fclose($fh);
}

//returns returns an array containing the whole log file
function readLog(){
    $file = "logFile.txt";
    $fh = fopen($file, 'r');
    $data = fread($fh, filesize($file));
    fclose($fh);
    $data = explode("\n", $data);
    return $data;
}

?>
