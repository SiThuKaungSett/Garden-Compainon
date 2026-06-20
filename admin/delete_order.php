<?php
include('config/dbcon.php');

if (isset($_POST['delete_btn'])) {
    $delete_id = mysqli_real_escape_string($con, $_POST['delete_id']);

    $query = "DELETE FROM orders WHERE order_id = '$delete_id'";
    $query_run = mysqli_query($con, $query);

    if ($query_run) {
        $_SESSION['status'] = "Order deleted successfully";
        header("Location: ../admin/order.php");
    } else {
        $_SESSION['status'] = "Order deletion failed";
        header("Location: ../admin/order.php");
    }
}
?>