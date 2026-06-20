<?php
require_once '../admin/config/dbcon.php';

$result = $con->query("SELECT name, password FROM admin");
while ($row = $result->fetch_assoc()) {
    $hashed_password = password_hash($row['password'], PASSWORD_DEFAULT);
    $stmt = $con->prepare("UPDATE admin SET password = ? WHERE name = ?");
    $stmt->bind_param("ss", $hashed_password, $row['name']);
    $stmt->execute();
}

$result = $con->query("SELECT u_name, u_password FROM user");
while ($row = $result->fetch_assoc()) {
    $hashed_password = password_hash($row['u_password'], PASSWORD_DEFAULT);
    $stmt = $con->prepare("UPDATE user SET u_password = ? WHERE u_name = ?");
    $stmt->bind_param("ss", $hashed_password, $row['u_name']);
    $stmt->execute();
}

echo "Passwords hashed successfully.";
?>
