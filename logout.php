<?php
session_start();

if (isset($_SESSION['auth'])) {
    unset($_SESSION['auth']);
    unset($_SESSION['auth_user']);
    unset($_SESSION['admin_name']);
    unset($_SESSION['user_name']);
    unset($_SESSION['role']);
    $_SESSION['message'] = "Logged out Successfully";
}

header('Location: adlogin.php');
exit();
?>