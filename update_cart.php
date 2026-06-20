<?php
session_start();
header('Content-Type: application/json');

$response = ['success' => false, 'error' => '', 'item_total' => 0, 'cart_subtotal' => 0];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = $_POST['product_id'];
    $quantity = intval($_POST['quantity']);

    if ($quantity < 1) {
        $quantity = 1; // Ensure at least 1 quantity
    }

    $item_found = false;
    $cart_subtotal = 0;

    // Loop through cart session to find the product and update quantity
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['product_id'] == $product_id) { 
            // Ensure product price is properly retrieved
            $item_price = floatval($item['product_price']);
            $item['quantity'] = $quantity;
            $item['total_price'] = $item_price * $quantity; // Calculate total price for this item
            $response['item_total'] = number_format($item['total_price']); // Format price properly
            $item_found = true;
        }

        // Add to the subtotal calculation
        $cart_subtotal += $item['product_price'] * $item['quantity'];
    }

    if (!$item_found) {
        $response['error'] = 'Item not found in cart';
        echo json_encode($response);
        exit;
    }

    // Update cart subtotal in session
    $_SESSION['cart_subtotal'] = $cart_subtotal;
    $response['cart_subtotal'] = number_format($cart_subtotal);
    $response['success'] = true;
} else {
    $response['error'] = 'Invalid request';
}

echo json_encode($response);
?>
