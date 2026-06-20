<?php
session_start();
include('includes/header.php');

if (isset($_GET['id'])) {
    $pid = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['id']);
}

// Fetch product details
$query = "SELECT * FROM plants WHERE p_id='$pid'";
$plantdata = mysqli_query($con, $query);
?>

<header>
  <a href="index.html" class="logo"><img src="logo/logo1.png" alt=""></a>

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

<?php while ($row = mysqli_fetch_assoc($plantdata)): ?>
<div class="more-details-container" id="moreDetails">
  <div class="image-container">
    <img src="uploads/<?= htmlspecialchars($row['p_image']); ?>">
    <div class="image-details">
      <p><strong>Price:</strong> <?= htmlspecialchars($row['price']); ?> Ks</p>
      <form action="cart.php" method="POST" target="hidden_iframe" onsubmit="showToast()">
          <p><strong>Quantity:</strong> <input type="number" name="quantity" min="1" value="1"></p>
          <input type="hidden" name="product_id" value="<?= htmlspecialchars($row['p_id']); ?>">
          <input type="hidden" name="product_name" value="<?= htmlspecialchars($row['p_name']); ?>">
          <input type="hidden" name="product_price" value="<?= htmlspecialchars($row['price']); ?>">
          <input type="hidden" name="product_image" value="<?= htmlspecialchars($row['p_image']); ?>">
          <?php if (!isset($_SESSION['auth_user'])): ?>
              <a href="adlogin.php?message=login_required" class="more-details-btn">Add to Cart</a>
          <?php else: ?>
              <button type="submit" class="more-details-btn">Add to Cart</button>
          <?php endif; ?>
      </form>
    </div>
  </div>
  
  <div class="more-details-content">
    <h2>Plant Details</h2>
    <p><strong>Plant Name:</strong> <?= htmlspecialchars($row['p_name']); ?></p>
    <p><strong>Description:</strong> <?= nl2br(htmlspecialchars($row['description'])); ?></p>
  </div>
</div>
<?php endwhile; ?>

<?php include('includes/footer.php'); ?>

<!-- Hidden iframe to handle form submission -->
<iframe name="hidden_iframe" style="display:none;"></iframe>

<!-- Toast Notification -->
<div id="toast" class="toast">Item added to cart successfully!</div>

<style>
.toast {
    visibility: hidden;
    max-width: 300px; /* Adjusted width */
    height: 50px;
    margin: auto;
    background-color: #333;
    color: #fff;
    text-align: center;
    border-radius: 2px;
    position: fixed;
    z-index: 1;
    left: 50%; /* Center horizontally */
    transform: translateX(-50%); /* Center horizontally */
    bottom: 30px;
    font-size: 17px;
    white-space: nowrap;
    display: flex; /* Use flexbox */
    align-items: center; /* Center text vertically */
    padding: 0 20px; /* Add padding */
}

.toast.show {
    visibility: visible;
    -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
    animation: fadein 0.5s, fadeout 0.5s 2.5s;
}

@-webkit-keyframes fadein {
    from {bottom: 0; opacity: 0;} 
    to {bottom: 30px; opacity: 1;}
}

@keyframes fadein {
    from {bottom: 0; opacity: 0;}
    to {bottom: 30px; opacity: 1;}
}

@-webkit-keyframes fadeout {
    from {bottom: 30px; opacity: 1;} 
    to {bottom: 0; opacity: 0;}
}

@keyframes fadeout {
    from {bottom: 30px; opacity: 1;}
    to {bottom: 0; opacity: 0;}
}
</style>

<script>
function showToast() {
    var x = document.getElementById("toast");
    x.className = "toast show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
}
</script>
