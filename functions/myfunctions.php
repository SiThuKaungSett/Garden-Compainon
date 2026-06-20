<?php
session_start();
include('../admin/config/dbcon.php');


    function getAll($table){
        global $con;
        $query = "SELECT * FROM $table";
        $query_run = mysqli_query($con, $query);
    }
?>