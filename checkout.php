<?php
session_start();
include('admin/config/dbcon.php'); // Database connection

header('Content-Type: application/json'); // Ensure JSON response

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $full_name = trim($_POST["full_name"] ?? '');
    $address = trim($_POST["address"] ?? '');
    $phone = trim($_POST["phone"] ?? '');
    $payment_method = $_POST["payment_method"] ?? '';
    $cart_items = $_SESSION["cart"] ?? [];

    // Validate required fields
    if (empty($full_name) || empty($address) || empty($phone) || empty($payment_method)) {
        echo json_encode(["success" => false, "error" => "Please fill in all required fields."]);
        exit;
    }

    // Check if cart is empty
    if (empty($cart_items)) {
        echo json_encode(["success" => false, "error" => "Your cart is empty!"]);
        exit;
    }

    // Validate user authentication
    if (!isset($_SESSION['auth_user']['user_id'])) {
        echo json_encode(["success" => false, "error" => "You must be logged in to place an order."]);
        exit;
    }

    $user_id = $_SESSION['auth_user']['user_id']; // Get the logged-in user's ID
    $order_date = date('Y-m-d'); // Get current date

    // Insert order into the database
    $order_success = true;
    foreach ($cart_items as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];

        // Insert order details into the orders table
        $query = "INSERT INTO orders (u_id, full_name, order_date, address, ph_no, payment, order_qty, p_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($query);
        if (!$stmt) {
            $order_success = false;
            break;
        }
        $stmt->bind_param("issssssi", $user_id, $full_name, $order_date, $address, $phone, $payment_method, $quantity, $product_id);
        if (!$stmt->execute()) {
            $order_success = false;
            break;
        }

        // Update the instock quantity in the plants table
        $update_query = "UPDATE plants SET instock = instock - ? WHERE p_id = ?";
        $update_stmt = $con->prepare($update_query);
        if (!$update_stmt) {
            $order_success = false;
            break;
        }
        $update_stmt->bind_param("ii", $quantity, $product_id);
        if (!$update_stmt->execute()) {
            $order_success = false;
            break;
        }
    }

    // Clear cart only if order was successful
    if ($order_success) {
        $_SESSION["cart"] = []; // Empty the cart session
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Error placing order. Please try again later."]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Invalid request."]);
}
