<?php
//takes the table from the staff directory as input in table.php
//registers all users in that table, and emails them a registration email

require_once('xmlToArrayParser.php');
require_once('../config/db.php');
require_once('../functions.php');

if(isset($_GET['action'])){
    if($_GET['action'] == "update"){
       updateDepartments();
    }
}

function updateDepartments(){
    $table = file_get_contents("final_table.php");
    //parse the html into nice arrays
    $parser = new xmlToArrayParser($table);
    $domObj = $parser->array;
    //drill down through the dom
    foreach($domObj as $table){
        foreach($table as $table2){
            foreach($table2 as $tbody){
                foreach($tbody as $tr){
                    $td = $tr[0];
                    $a = $td['a'];
                    $attrib = $a['attrib'];
                    $email = $attrib['title'];
                    $user_exploded = explode("@", $email);

                    $username = $user_exploded[0];
                    $department_name = $tr[1];
                    if (!sqlSelectOne("SELECT * FROM departments WHERE department_name='$department_name'", 'department_id')) {
                        sqlQuery("INSERT INTO departments (department_name) VALUES ('$department_name')");
                        print "Added department: " . $department_name . "<br />";
                    }
                    $department = sqlSelectOne("SELECT * FROM departments WHERE department_name='$department_name'", 'department_id');
                    sqlQuery("UPDATE users SET user_department='$department' WHERE user_username='$username'");

                    print $username . " | " . $department_name . "<br />";

                }
            }
        }
    }
}

?>
<a href = "add_departments.php?action=update">Update Departments</a>
