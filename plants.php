<?php
session_start();
include('includes/header.php');

$limit = 8;
$page  = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;
$season = isset($_GET['season']) ? $_GET['season'] : 'All';
$start  = ($page - 1) * $limit;

if ($season == 'All') {
    $sql       = "SELECT p_id, p_name, p_image, price, season FROM plants LIMIT $start, $limit";
    $total_sql = "SELECT COUNT(*) FROM plants";
} else {
    $sql       = "SELECT p_id, p_name, p_image, price, season FROM plants WHERE season = '$season' LIMIT $start, $limit";
    $total_sql = "SELECT COUNT(*) FROM plants WHERE season = '$season'";
}

$plantdata    = mysqli_query($con, $sql);
$total_result = mysqli_query($con, $total_sql);
$total_rows   = mysqli_fetch_array($total_result)[0];
$total_pages  = ceil($total_rows / $limit);
?>

<!-- NAV — identical to index -->
<header class="gc-header">
  <div class="gc-nav-brand">
    <div class="gc-brand-icon">
      <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#7EAD88" stroke-width="2" stroke-linecap="round">
        <path d="M12 22V12M12 12C12 7 17 3 22 3C22 8 18 12 12 12ZM12 12C12 7 7 3 2 3C2 8 6 12 12 12Z"/>
      </svg>
    </div>
    <div class="gc-brand-text">
      <span>Garden Companion</span>
      <small>Grow with nature</small>
    </div>
  </div>

  <ul class="gc-navmenu">
    <li><a href="index.php">Home</a></li>
    <li class="active"><a href="plants.php">Plants</a></li>
    <li><a href="aboutus.php">About Us</a></li>
    <li><a href="feedback.php">Feedback</a></li>
  </ul>

  <div class="gc-nav-right">
    <div class="gc-search-bar">
      <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="#888" stroke-width="2.5" stroke-linecap="round">
        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
      </svg>
      <input class="gc-search-input" type="search" id="searchBox" placeholder="Search plants..." maxlength="50">
      <ul id="searchResults" class="search-results"></ul>
    </div>
    <?php if (isset($_SESSION['auth_user'])): ?>
      <?php $cartCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
      <a href="cart.php" class="gc-icon-btn" title="Cart">
        <i class='bx bx-cart'></i>
        <?php if ($cartCount > 0): ?>
          <span class="gc-cart-badge"><?php echo $cartCount; ?></span>
        <?php endif; ?>
      </a>
      <a href="logout.php" class="gc-icon-btn" title="Logout"><i class='bx bx-log-out'></i></a>
    <?php else: ?>
      <a href="adlogin.php" class="gc-icon-btn" title="Login"><i class='bx bx-user-circle'></i></a>
    <?php endif; ?>
  </div>
</header>

<!-- PAGE HEADER STRIP -->
<div class="pl-page-header">
  <div class="pl-page-header-inner">
    <div class="pl-breadcrumb">
      <a href="index.php">Home</a>
      <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m9 18 6-6-6-6"/></svg>
      <span>Plants</span>
    </div>
    <h1 class="pl-page-title">
      <?php if ($season !== 'All'): ?>
        <?= htmlspecialchars($season) ?>
      <?php else: ?>
        All Plants
      <?php endif; ?>
    </h1>
    <p class="pl-page-sub"><?= $total_rows ?> varieties available</p>
  </div>
</div>

<!-- SEASON FILTER PILLS -->
<div class="pl-filter-wrap">
  <div class="pl-filter-inner">
    <span class="pl-filter-label">Season</span>
    <div class="pl-filter-pills">
      <?php
      $seasons = ['All' => 'All Seasons', 'Hot Season' => '☀️ Hot', 'Rainy Season' => '🌧️ Rainy', 'Cold Season' => '❄️ Cold'];
      foreach ($seasons as $val => $label):
      ?>
      <a href="plants.php?season=<?= urlencode($val) ?>"
         class="pl-pill <?= ($season === $val) ? 'pl-pill-active' : '' ?>"><?= $label ?></a>
      <?php endforeach; ?>
    </div>
    <p class="pl-result-count"><?= $total_rows ?> results</p>
  </div>
</div>

<!-- PRODUCT GRID -->
<div class="pl-grid-wrap">
  <div class="pl-grid">
    <?php $idx = 0; while ($row = mysqli_fetch_assoc($plantdata)): $idx++; ?>
    <a href="moredetail.php?id=<?= $row['p_id'] ?>" class="pl-card gc-card-reveal" style="--card-delay:<?= min($idx * 50, 400) ?>ms">
      <div class="pl-card-img">
        <img src="uploads/<?= htmlspecialchars($row['p_image']) ?>" alt="<?= htmlspecialchars($row['p_name']) ?>" loading="lazy">
        <span class="pl-season-dot pl-dot-<?= strtolower(explode(' ', $row['season'])[0]) ?>">
          <?= $row['season'] === 'Hot Season' ? '☀️' : ($row['season'] === 'Rainy Season' ? '🌧️' : '❄️') ?>
        </span>
      </div>
      <div class="pl-card-body">
        <p class="pl-card-name"><?= htmlspecialchars($row['p_name']) ?></p>
        <div class="pl-card-foot">
          <span class="pl-card-price"><?= number_format($row['price']) ?> Ks</span>
          <span class="pl-card-cta">
            View
            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </span>
        </div>
      </div>
    </a>
    <?php endwhile; ?>
  </div>
</div>

<!-- PAGINATION -->
<?php if ($total_pages > 1): ?>
<div class="pl-pagination">
  <?php if ($page > 1): ?>
    <a href="?season=<?= urlencode($season) ?>&page=<?= $page - 1 ?>" class="pl-page-btn pl-page-prev" aria-label="Previous page">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m15 18-6-6 6-6"/></svg>
    </a>
  <?php else: ?>
    <span class="pl-page-btn pl-page-prev pl-page-disabled" aria-disabled="true">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m15 18-6-6 6-6"/></svg>
    </span>
  <?php endif; ?>

  <?php for ($i = 1; $i <= $total_pages; $i++): ?>
    <a href="?season=<?= urlencode($season) ?>&page=<?= $i ?>"
       class="pl-page-num <?= ($i === $page) ? 'pl-page-active' : '' ?>"
       aria-current="<?= ($i === $page) ? 'page' : 'false' ?>"><?= $i ?></a>
  <?php endfor; ?>

  <?php if ($page < $total_pages): ?>
    <a href="?season=<?= urlencode($season) ?>&page=<?= $page + 1 ?>" class="pl-page-btn pl-page-next" aria-label="Next page">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m9 18 6-6-6-6"/></svg>
    </a>
  <?php else: ?>
    <span class="pl-page-btn pl-page-next pl-page-disabled" aria-disabled="true">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m9 18 6-6-6-6"/></svg>
    </span>
  <?php endif; ?>
</div>
<?php endif; ?>

<?php include('includes/footer.php'); ?>