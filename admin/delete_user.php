<?php
include('config/dbcon.php');

if (isset($_POST['delete_btn'])) {
    $delete_id = mysqli_real_escape_string($con, $_POST['delete_id']);

    $query = "DELETE FROM user WHERE u_id = '$delete_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $_SESSION['status'] = "User deleted successfully";
        header("Location: ../admin/useraccount.php");
    } else {
        $_SESSION['status'] = "User deletion failed";
        header("Location: ../admin/useraccount.php");
    }
}
?>