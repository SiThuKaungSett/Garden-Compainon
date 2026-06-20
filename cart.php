<?php
session_start();
include('includes/header.php');

// Initialize cart if not already initialized
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Handle adding product to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id']) && !isset($_POST['remove'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'] ?? '';
    $product_price = $_POST['product_price'] ?? 0;
    $quantity = intval($_POST['quantity'] ?? 1);
    $product_image = $_POST['product_image'] ?? '';

    // Check if product is already in the cart
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['product_id'] === $product_id) {
            $item['quantity'] += $quantity;
            $found = true;
            break;
        }
    }
    if (!$found) {
        $_SESSION['cart'][] = [
            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_price' => $product_price,
            'quantity' => $quantity,
            'product_image' => $product_image
        ];
    }

    // If the request is an iframe request, do not redirect
    if (isset($_POST['iframe'])) {
        echo "Item added to cart successfully!";
        exit;
    } else {
        // Redirect to cart.php if not an iframe request
        header('Location: cart.php');
        exit;
    }
}

// Handle removing product from cart
if (isset($_POST['remove'])) {
    $product_id = $_POST['product_id'];
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['product_id'] === $product_id) {
            unset($_SESSION['cart'][$key]);
            break;
        }
    }
    $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index array to avoid duplicate display issues
    header('Location: cart.php');
    exit;
}

?>

<header>
    <a href="index.php" class="logo"><img src="logo/logo1.png" alt=""></a>
    <ul class="navmenu">
        <li><a href="index.php">Home</a></li>
        <li class="active"><a href="plants.php">Plants</a></li>
        <li><a href="aboutus.php">About Us</a></li>
        <li><a href="feedback.php">Feedback</a></li>
    </ul>
    <div class="nav-icon">
        <input class="search-input" type="search" id="searchBox" placeholder="Search...." maxlength="50">
        <button class="search-button" type="submit">
            <i class='bx bx-search'></i>
        </button>
        <ul id="searchResults" class="search-results"></ul>
        <?php
        if (isset($_SESSION['auth_user'])) {
            $cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
            echo "<a href='cart.php' class='cart-icon'>
              <i class='bx bx-cart'></i>";
            if ($cartCount > 0) {
                echo "<span class='cart-badge'>$cartCount</span>";
            }
            echo "</a>";
            echo "<a href='logout.php'><i class='bx bx-log-out'></i></a>";
        } else {
        ?>
            <a href="adlogin.php"><i class='bx bx-user-circle'></i></a>
        <?php
        }
        ?>
    </div>
</header>

<div class="cart-container">
    <h1 class="cart-title">Your Shopping Cart</h1>
    <div class="cart-content">
        <div class="cart-items">
            <?php
            $subtotal = 0;
            if (!empty($_SESSION['cart'])):
                foreach ($_SESSION['cart'] as $item):
                    $total_price = $item['product_price'] * $item['quantity'];
                    $subtotal += $total_price;
            ?>
                    <div class="cart-item">
                        <div class="cart-image">
                            <img src="uploads/<?= $item['product_image']; ?>" alt="<?= htmlspecialchars($item['product_name']); ?>">
                        </div>
                        <div class="cart-details">
                            <h2 class="cart-product-title"><?= htmlspecialchars($item['product_name']); ?></h2>
                            <p class="cart-price"> <?= $item['product_price'] ?> Ks</p>
                        </div>
                        <div class="cart-quantity">
                            <input type="number" class="cart-quantity-input" data-product-id="<?= $item['product_id']; ?>" value="<?= $item['quantity']; ?>" min="1">
                        </div>
                        <div class="cart-total" data-product-id="<?= $item['product_id']; ?>">
                            <?= $total_price ?> Ks
                        </div>
                        <form action="cart.php" method="POST">
                            <input type="hidden" name="product_id" value="<?= $item['product_id']; ?>">
                            <button type="submit" name="remove" class="cart-remove">Remove</button>
                        </form>
                    </div>
                <?php endforeach;
            else: ?>
                <p class="empty-cart">Your cart is empty.</p>
            <?php endif; ?>
        </div>

        <div class="cart-summary">
            <h3>Cart Summary</h3>
            <div class="summary-details">
                <p class="summary-total">Total: <span id="cart-total"> <?= $subtotal; ?> Ks</span></p>
            </div>
            <button class="checkout-btn">Proceed to Checkout</button>
        </div>
    </div>

    <!-- Checkout Modal -->
    <div id="checkout-modal" class="checkout-modal">
        <div class="checkout-content">
            <span class="close-btn">&times;</span>
            <h2 class="checkout-title">Checkout</h2>

            <div class="checkout-form-container">
                <!-- Left Section: User Details -->
                <div class="checkout-left">
                    <form id="checkout-form" action="checkout.php" method="POST">
                        <label for="full-name">Full Name:</label>
                        <input type="text" id="full-name" name="full_name" required placeholder="Enter your full name">

                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address" required placeholder="Enter your address">

                        <label for="phone">Phone Number:</label>
                        <input type="text" id="phone" name="phone" required placeholder="Enter your phone number">

                        <!-- Payment Method Section (Fixed Positioning) -->
                        <label class="payment-method-label">Payment Method:</label>
                        <div class="payment-options">
                            <label class="payment-method" for="kbzpay">
                                <input type="radio" id="kbzpay" name="payment_method" value="KBZpay" required>
                                <img src="logo/kbzpay.png" alt="KBZPay">
                            </label>
                            <div class="qr-code">
                                <img src="images/qr.jpg" alt="QR Code">
                            </div>
                        </div>

                        <!-- Centered "Or" Text -->
                        <p class="or-text">Or</p>

                        <!-- Cash on Delivery Option (Centered Below "Or") -->
                        <label class="cod-option">
                            <input type="radio" name="payment_method" value="Cash on Delivery">
                            <span>Cash on Delivery</span>
                        </label>
                    </form>
                </div>

                <!-- Right Section: Order Summary -->
                <div class="checkout-right">
                    <div class="item-summary">
                        <h3>Item Summary</h3>
                        <ul id="checkout-items">
                            <?php foreach ($_SESSION['cart'] as $item): ?>
                                <li><?= htmlspecialchars($item['product_name']) ?> x <?= $item['quantity'] ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <div class="total-cost">
                        <p>Total: <span id="checkout-total"><?= $subtotal ?> Ks</span></p>
                    </div>

                    <button type="submit" form="checkout-form" name="confirm_order" class="checkout-submit">Confirm Order</button>
                </div>
            </div>
        </div>
    </div>

   <!-- Order Success Modal -->
<div id="order-success-modal" class="modal">
    <div class="modal-content">
        <div class="success-icon">&#10004;</div> <!-- Checkmark icon -->
        <h2>Thank You</h2>
        <p>Your order has been placed successfully!</p>
        <button id="success-ok-btn">OK</button>
    </div>
</div>


</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="cart.js"></script>

<?php include('includes/footer.php'); ?>