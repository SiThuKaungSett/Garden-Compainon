<?php
session_start();
include('admin/config/dbcon.php'); // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = trim($_POST["name"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $message = trim($_POST["message"] ?? '');
    $rating = intval($_POST["rating"] ?? 0);

    // Validate required fields
    if (empty($name) || empty($email) || empty($message) || $rating == 0) {
        echo json_encode(["success" => false, "message" => "Please fill in all required fields."]);
        exit;
    }

    // Prepare and execute the SQL query to insert feedback into the database
    $query = "INSERT INTO feedback (u_name, email, feedback_text, star) VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($query);
    if ($stmt) {
        $stmt->bind_param("sssi", $name, $email, $message, $rating);
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Feedback submitted successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Error submitting feedback. Please try again later."]);
        }
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Error preparing the statement."]);
    }

    $con->close();
} else {
    echo json_encode(["success" => false, "message" => "Invalid request."]);
}
?>