<?php
session_start();
include('includes/header.php');

if (isset($_GET['id'])) {
    $pid = preg_replace('/[^-a-zA-Z0-9_]/', '', $_GET['id']);
}

$query     = "SELECT * FROM plants WHERE p_id='$pid'";
$plantdata = mysqli_query($con, $query);
$row       = mysqli_fetch_assoc($plantdata);
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
        <?php if ($cartCount > 0): ?><span class="gc-cart-badge"><?php echo $cartCount; ?></span><?php endif; ?>
      </a>
      <a href="logout.php" class="gc-icon-btn" title="Logout"><i class='bx bx-log-out'></i></a>
    <?php else: ?>
      <a href="adlogin.php" class="gc-icon-btn" title="Login"><i class='bx bx-user-circle'></i></a>
    <?php endif; ?>
  </div>
</header>

<?php if ($row): ?>
<!-- DETAIL LAYOUT -->
<div class="md-wrap">

  <!-- BREADCRUMB -->
  <nav class="md-breadcrumb" aria-label="Breadcrumb">
    <a href="index.php">Home</a>
    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m9 18 6-6-6-6"/></svg>
    <a href="plants.php">Plants</a>
    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m9 18 6-6-6-6"/></svg>
    <span><?= htmlspecialchars($row['p_name']) ?></span>
  </nav>

  <div class="md-layout">

    <!-- LEFT: image panel -->
    <div class="md-image-panel">
      <div class="md-image-wrap">
        <img src="uploads/<?= htmlspecialchars($row['p_image']) ?>"
             alt="<?= htmlspecialchars($row['p_name']) ?>"
             class="md-plant-img">
        <!-- season badge on image -->
        <span class="md-season-badge">
          <?php
          $s = $row['season'] ?? '';
          echo $s === 'Hot Season' ? '☀️ Hot Season' : ($s === 'Rainy Season' ? '🌧️ Rainy Season' : '❄️ Cold Season');
          ?>
        </span>
      </div>

      <!-- key facts strip under image -->
      <div class="md-facts">
        <div class="md-fact">
          <span class="md-fact-label">Stock</span>
          <span class="md-fact-val"><?= htmlspecialchars($row['instock'] ?? '—') ?></span>
        </div>
        <div class="md-fact-divider"></div>
        <div class="md-fact">
          <span class="md-fact-label">Season</span>
          <span class="md-fact-val"><?= htmlspecialchars($row['season'] ?? '—') ?></span>
        </div>
        <div class="md-fact-divider"></div>
        <div class="md-fact">
          <span class="md-fact-label">Price</span>
          <span class="md-fact-val md-price-val"><?= number_format($row['price']) ?> Ks</span>
        </div>
      </div>
    </div>

    <!-- RIGHT: details + cart -->
    <div class="md-detail-panel">
      <p class="md-season-eyebrow">
        <?= htmlspecialchars($row['season'] ?? '') ?>
      </p>
      <h1 class="md-plant-name"><?= htmlspecialchars($row['p_name']) ?></h1>

      <div class="md-price-row">
        <span class="md-price"><?= number_format($row['price']) ?></span>
        <span class="md-price-unit">MMK</span>
      </div>

      <div class="md-divider"></div>

      <!-- Description -->
      <div class="md-desc-section">
        <p class="md-desc-label">About this plant</p>
        <div class="md-desc-text">
          <?= nl2br(htmlspecialchars($row['description'] ?? '')) ?>
        </div>
      </div>

      <div class="md-divider"></div>

      <!-- Add to cart form -->
      <form class="md-cart-form" action="cart.php" method="POST"
            target="hidden_iframe" onsubmit="gcShowToast()">
        <input type="hidden" name="product_id"    value="<?= htmlspecialchars($row['p_id']) ?>">
        <input type="hidden" name="product_name"  value="<?= htmlspecialchars($row['p_name']) ?>">
        <input type="hidden" name="product_price" value="<?= htmlspecialchars($row['price']) ?>">
        <input type="hidden" name="product_image" value="<?= htmlspecialchars($row['p_image']) ?>">

        <div class="md-qty-row">
          <label class="md-qty-label" for="md-qty">Quantity</label>
          <div class="md-qty-control">
            <button type="button" class="md-qty-btn" id="md-qty-minus" aria-label="Decrease quantity">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14"/></svg>
            </button>
            <input type="number" name="quantity" id="md-qty" class="md-qty-input" min="1" value="1" readonly>
            <button type="button" class="md-qty-btn" id="md-qty-plus" aria-label="Increase quantity">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
            </button>
          </div>
        </div>

        <?php if (!isset($_SESSION['auth_user'])): ?>
          <a href="adlogin.php?message=login_required" class="md-cart-btn md-cart-btn-login">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            Sign in to add to cart
          </a>
        <?php else: ?>
          <button type="submit" class="md-cart-btn" id="md-add-btn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            Add to cart
          </button>
        <?php endif; ?>

        <a href="plants.php" class="md-back-link">
          <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="m15 18-6-6 6-6"/></svg>
          Back to plants
        </a>
      </form>

    </div>
  </div>
</div>
<?php else: ?>
  <div class="md-not-found">
    <p>Plant not found.</p>
    <a href="plants.php" class="gc-btn-primary">Browse all plants</a>
  </div>
<?php endif; ?>

<!-- Toast -->
<div id="gc-toast" class="gc-toast" role="alert" aria-live="polite">
  <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M20 6 9 17l-5-5"/></svg>
  Added to cart
</div>

<iframe name="hidden_iframe" style="display:none;" title="Cart submission"></iframe>

<script>
/* Quantity stepper */
(function(){
  const input = document.getElementById('md-qty');
  const minus = document.getElementById('md-qty-minus');
  const plus  = document.getElementById('md-qty-plus');
  if(!input) return;
  minus.addEventListener('click', () => {
    const v = parseInt(input.value, 10);
    if(v > 1) input.value = v - 1;
    minus.disabled = parseInt(input.value,10) <= 1;
  });
  plus.addEventListener('click', () => {
    input.value = parseInt(input.value, 10) + 1;
    minus.disabled = false;
  });
  minus.disabled = true;
})();

/* Add to cart button pulse */
(function(){
  const btn = document.getElementById('md-add-btn');
  if(!btn) return;
  btn.addEventListener('click', function(){
    btn.classList.add('gc-btn-pulse');
    setTimeout(() => btn.classList.remove('gc-btn-pulse'), 400);
  });
})();

/* Toast */
function gcShowToast(){
  const t = document.getElementById('gc-toast');
  t.classList.add('gc-toast-show');
  setTimeout(() => t.classList.remove('gc-toast-show'), 3200);
}
</script>

<?php include('includes/footer.php'); ?>