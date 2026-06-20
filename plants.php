<?php
session_start();
include('includes/header.php');

// Define how many products per page
$limit = 8; // Change this value to control how many products appear per page

// Get the current page number from the URL, default to 1 if not set
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1); // Ensure the page number is at least 1

// Get the selected season from the dropdown
$season = isset($_GET['season']) ? $_GET['season'] : 'All';

// Calculate the starting row for the query
$start = ($page - 1) * $limit;

// Construct the SQL query based on the selected season
if ($season == 'All') {
    $sql = "SELECT p_id, p_name, p_image, price, season FROM plants LIMIT $start, $limit";
    $total_sql = "SELECT COUNT(*) FROM plants";
} else {
    $sql = "SELECT p_id, p_name, p_image, price, season FROM plants WHERE season = '$season' LIMIT $start, $limit";
    $total_sql = "SELECT COUNT(*) FROM plants WHERE season = '$season'";
}

$plantdata = mysqli_query($con, $sql);
$total_result = mysqli_query($con, $total_sql);
$total_rows = mysqli_fetch_array($total_result)[0];
$total_pages = ceil($total_rows / $limit);
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
</header>

<!-- Season Filter -->
<div class="season-filter">
    <label for="season" class="season-label">Want to plant in</label>
    <form method="GET" action="">
        <div class="custom-select-wrapper">
            <select name="season" id="season" onchange="this.form.submit()">
                <option value="All" <?= ($season == 'All') ? 'selected' : '' ?>>All Seasons</option>
                <option value="Hot Season" <?= ($season == 'Hot Season') ? 'selected' : '' ?>>Hot Season</option>
                <option value="Rainy Season" <?= ($season == 'Rainy Season') ? 'selected' : '' ?>>Rainy Season</option>
                <option value="Cold Season" <?= ($season == 'Cold Season') ? 'selected' : '' ?>>Cold Season</option>
            </select>
            <i class='bx bx-chevron-down'></i>
        </div>
    </form>
</div>

<main>
    <?php while ($row = mysqli_fetch_assoc($plantdata)): ?>
        <div class="card">
            <div class="image">
                <img src="uploads/<?= $row['p_image']; ?>">
            </div>
            <div class="caption">
                <p class="plant_name"><?= $row['p_name'] ?></p>
                <p class="price"><?= $row['price'] ?>Ks</p>
            </div>
            <div class="box">
                <input type="hidden" name="pedit_id" value="<?php echo $row['p_id']; ?>">
                <a href="moredetail.php?id=<?= $row['p_id'] ?>" id="moredetail-btn">
                    <button class="detail">More Detail</button>
                </a> 
            </div>
        </div>
    <?php endwhile; ?>
</main>

<!-- Pagination Links -->
<div class="pagination">
    <?php if ($page > 1): ?>
        <a href="?season=<?= $season ?>&page=<?= $page - 1 ?>" class="prev">Previous</a>
    <?php else: ?>
        <a href="#" class="prev disabled">Previous</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?season=<?= $season ?>&page=<?= $i ?>" class="<?= ($i == $page) ? 'active' : '' ?>"><?= $i ?></a>
    <?php endfor; ?>

    <?php if ($page < $total_pages): ?>
        <a href="?season=<?= $season ?>&page=<?= $page + 1 ?>" class="next">Next</a>
    <?php else: ?>
        <a href="#" class="next disabled">Next</a>
    <?php endif; ?>
</div>


<?php include('includes/footer.php'); ?>
