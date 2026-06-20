<?php

session_start();
require_once '../admin/config/dbcon.php';

// Handle Login
if (isset($_POST['login_btn'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']); // Trim input to avoid extra spaces

    // Check in admin table first
    $stmt = $con->prepare("SELECT 'admin' AS role, name AS username, password FROM admin WHERE name = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $admin_result = $stmt->get_result();

    if ($admin_result->num_rows == 1) {
        $account = $admin_result->fetch_assoc();
    } else {
        // Check in user table if not found in admin table
        $stmt = $con->prepare("SELECT 'user' AS role, u_id, u_name AS username, u_password FROM user WHERE u_name = ?");
$stmt->bind_param("s", $username);
        $stmt->execute();
        $user_result = $stmt->get_result();

        if ($user_result->num_rows == 1) {
            $account = $user_result->fetch_assoc();
        } else {
            $_SESSION['error'] = "No account found with this username.";
            header("Location: ../adlogin.php");
            exit();
        }
    }

    // Verify password
    $db_password = trim($account['password'] ?? $account['u_password']); // Ensure trimmed password

    if (password_verify($password, $db_password)) {
        // If password is correct, start session
        $_SESSION['auth'] = true;
        $_SESSION['auth_user'] = [
            'user_id' => $account['u_id'], 
            'name' => $account['username'],
        ];
        

        if ($account['role'] === 'admin') {
            $_SESSION['admin_name'] = $account['username'];
            $_SESSION['role'] = 'admin';
            header("Location: ../admin/index.php");
            exit();
        } else {
            $_SESSION['user_name'] = $account['username'];
            $_SESSION['role'] = 'user';
            header("Location: ../index.php");
            exit();
        }
    } else {
        $_SESSION['error'] = "Incorrect password.";
        header("Location: ../adlogin.php");
        exit();
    }
}

// Handle Registration
if (isset($_POST['register_btn'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['cnpassword']);

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
    } elseif (strlen($password) < 8) {
        $_SESSION['error'] = "Password must be at least 8 characters long.";
    } elseif (!preg_match("/[a-z]/", $password)) {
        $_SESSION['error'] = "Password must contain at least one lowercase letter.";
    } elseif (!preg_match("/[A-Z]/", $password)) {
        $_SESSION['error'] = "Password must contain at least one uppercase letter.";
    } elseif (!preg_match("/\d/", $password)) {
        $_SESSION['error'] = "Password must contain at least one number.";
    } elseif (!preg_match("/[@$!%*?#&]/", $password)) {
        $_SESSION['error'] = "Password must contain at least one special symbol.";
    } elseif ($password !== $confirm_password) {
        $_SESSION['error'] = "Two passwords didn't match.";
    } else {
        // Hash password before storing
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert into user table
        $stmt = $con->prepare("INSERT INTO user (u_name, email, u_password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);
        
        if ($stmt->execute()) {
            
            header("Location: ../adlogin.php");
            exit();
        } else {
            $_SESSION['error'] = "Error creating account. Please try again.";
        }
    }

    // Redirect back to adlogin.php with error
    header("Location: ../adlogin.php");
    exit();
}