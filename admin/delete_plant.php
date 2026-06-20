<?php
include('config/dbcon.php');

if (isset($_POST['delete_btn'])) {
    $delete_id = mysqli_real_escape_string($con, $_POST['delete_id']);

    $query = "DELETE FROM plants WHERE p_id = '$delete_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $_SESSION['status'] = "Plant deleted successfully";
        header("Location: index.php");
    } else {
        $_SESSION['status'] = "Plant deletion failed";
        header("Location: index.php");
    }
}
?>