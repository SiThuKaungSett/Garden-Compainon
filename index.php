<?php
session_start();
include('includes/header.php'); ?>

<header>
  <a href="index.php" class="logo"><img src="assets/logo/logo1.png" alt=""></a>

  <ul class="navmenu">
    <li class="active"><a href="index.php">Home</a></li>
    <li><a href="plants.php">Plants</a></li>
    
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

<div class="home-content">
  <!-- Intro Section -->
  <section class="intro">
    <div class="text">
      <h1>Welcome to Garden Companion</h1>
      <p>Your one-stop shop for all your plant seed needs. Explore our wide range of products categorized by season to help you find the perfect seeds for your garden.</p>
    </div>
  </section>

  
  <!-- Category Container with Grid Layout -->
<h2 class="category-title">Explore Our Seasonal Seeds</h2>
<div class="category-container">

    
    <!-- Hot Season Section -->
    <section class="category hot-season">
      <div class="overlay"></div>
      <div class="text">
        <h2>Hot Season</h2>
        <p>Discover the best seeds for the hot season. Perfect for growing in warm climates.</p>
        <a href="plants.php?season=Hot+Season" class="btn">Explore</a>
      </div>
    </section>

    <!-- Rainy Season Section -->
    <section class="category rainy-season">
      <div class="overlay"></div>
      <div class="text">
        <h2>Rainy Season</h2>
        <p>Find the ideal seeds for the rainy season. Great for growing in wet conditions.</p>
        <a href="plants.php?season=Rainy+Season" class="btn">Explore</a>
      </div>
    </section>

    <!-- Cold Season Section -->
    <section class="category cold-season">
      <div class="overlay"></div>
      <div class="text">
        <h2>Cold Season</h2>
        <p>Check out the best seeds for the cold season. Suitable for growing in cooler climates.</p>
        <a href="plants.php?season=Cold+Season" class="btn">Explore</a>
      </div>
    </section>
  </div>
</div>

<?php include('includes/footer.php'); ?>