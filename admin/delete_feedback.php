<?php
include('config/dbcon.php');

if (isset($_POST['delete_btn'])) {
    $delete_id = mysqli_real_escape_string($con, $_POST['delete_id']);

    $query = "DELETE FROM feedback WHERE feedback_id = '$delete_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $_SESSION['status'] = "Feedback deleted successfully";
        header("Location: ../admin/feedback.php");
    } else {
        $_SESSION['status'] = "Feedback deletion failed";
        header("Location: ../admin/feedback.php");
    }
}
?>