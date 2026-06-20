<?php
session_start();
include('includes/header.php'); ?>

<!-- NAV -->
<header class="gc-header">
  <div class="gc-nav-brand">
    <div class="gc-brand-icon">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#8FC99E" stroke-width="2">
        <path d="M12 22V12M12 12C12 7 17 3 22 3C22 8 18 12 12 12ZM12 12C12 7 7 3 2 3C2 8 6 12 12 12Z"/>
      </svg>
    </div>
    <div class="gc-brand-text">
      <span>Garden Companion</span>
      <small>Grow with nature</small>
    </div>
  </div>

  <ul class="gc-navmenu">
    <li class="active"><a href="index.php">Home</a></li>
    <li><a href="plants.php">Plants</a></li>
    <li><a href="aboutus.php">About Us</a></li>
    <li><a href="feedback.php">Feedback</a></li>
  </ul>

  <div class="gc-nav-right">
    <div class="gc-search-bar">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#888" stroke-width="2">
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
      <a href="logout.php" class="gc-icon-btn" title="Logout">
        <i class='bx bx-log-out'></i>
      </a>
    <?php else: ?>
      <a href="adlogin.php" class="gc-icon-btn" title="Login">
        <i class='bx bx-user-circle'></i>
      </a>
    <?php endif; ?>
  </div>
</header>

<!-- HERO -->
<section class="gc-hero">
  <div class="gc-hero-bg-pattern"></div>
  <svg class="gc-hero-leaves" viewBox="0 0 1200 800" preserveAspectRatio="xMidYMid slice" xmlns="http://www.w3.org/2000/svg">
    <g opacity="0.08" fill="#8FC99E">
      <ellipse cx="1100" cy="100" rx="180" ry="90" transform="rotate(-30 1100 100)"/>
      <ellipse cx="1130" cy="130" rx="120" ry="60" transform="rotate(15 1130 130)"/>
      <ellipse cx="80" cy="680" rx="140" ry="70" transform="rotate(20 80 680)"/>
      <ellipse cx="50" cy="650" rx="90" ry="45" transform="rotate(-10 50 650)"/>
    </g>
    <g opacity="0.05" stroke="#C4956A" stroke-width="1" fill="none">
      <path d="M950 50 Q1000 200 1100 300"/>
      <path d="M1000 80 Q1050 180 1080 280"/>
      <path d="M0 700 Q100 600 200 500"/>
    </g>
  </svg>

  <div class="gc-hero-content">
    <div class="gc-hero-text">
      <div class="gc-hero-eyebrow">🌿 Your garden starts here</div>
      <h1 class="gc-hero-title">Grow Your <em>Dream</em> Garden,<br>Season by Season</h1>
      <p class="gc-hero-desc">Discover the perfect seeds for every climate. From hot summer blooms to cold-hardy winter crops — we guide every step of your growing journey.</p>
      <div class="gc-hero-actions">
        <a href="plants.php" class="gc-btn-primary">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
          </svg>
          Explore Plants
        </a>
        <a href="feedback.php" class="gc-btn-outline">Leave Feedback</a>
      </div>
      <div class="gc-hero-stats">
        <div class="gc-stat"><div class="gc-stat-num">120+</div><div class="gc-stat-label">Plant varieties</div></div>
        <div class="gc-stat"><div class="gc-stat-num">3</div><div class="gc-stat-label">Seasons covered</div></div>
        <div class="gc-stat"><div class="gc-stat-num">100%</div><div class="gc-stat-label">Locally sourced</div></div>
      </div>
    </div>

    <div class="gc-hero-visual">
      <div class="gc-plant-showcase">
        <div class="gc-plant-tag">🌞 Hot Season Pick</div>
        <div class="gc-plant-name">Thai Basil Seeds</div>
        <div class="gc-plant-latin">Ocimum basilicum var. thyrsiflora</div>
        <div class="gc-plant-attrs">
          <div class="gc-attr"><div class="gc-attr-label">Difficulty</div><div class="gc-attr-val">Easy</div></div>
          <div class="gc-attr"><div class="gc-attr-label">Days to harvest</div><div class="gc-attr-val">45–60</div></div>
          <div class="gc-attr"><div class="gc-attr-label">Sunlight</div><div class="gc-attr-val">Full sun</div></div>
        </div>
      </div>
      <div class="gc-mini-cards">
        <div class="gc-mini-card"><div class="gc-mc-icon">🌧️</div><div class="gc-mc-name">Lemongrass</div><div class="gc-mc-season">Rainy season</div></div>
        <div class="gc-mini-card"><div class="gc-mc-icon">❄️</div><div class="gc-mc-name">Kale</div><div class="gc-mc-season">Cold season</div></div>
        <div class="gc-mini-card"><div class="gc-mc-icon">☀️</div><div class="gc-mc-name">Chili Pepper</div><div class="gc-mc-season">Hot season</div></div>
        <div class="gc-mini-card"><div class="gc-mc-icon">🌿</div><div class="gc-mc-name">Mint</div><div class="gc-mc-season">All seasons</div></div>
      </div>
    </div>
  </div>
</section>

<!-- SEASONS -->
<section class="gc-seasons-section">
  <div class="gc-section-eyebrow">Browse by season</div>
  <h2 class="gc-section-title">What grows<br>in your climate?</h2>
  <div class="gc-seasons-grid">
    <div class="gc-season-card">
      <div class="gc-season-bg gc-hot-bg"><div class="gc-season-illustration">☀️</div></div>
      <div class="gc-season-overlay"></div>
      <div class="gc-season-content">
        <div class="gc-season-badge">☀️ Hot Season</div>
        <h3 class="gc-season-title">Heat-Loving Plants</h3>
        <p class="gc-season-desc">Seeds that thrive under the tropical sun — bold flavors, vibrant colors.</p>
        <a href="plants.php?season=Hot+Season" class="gc-season-link">
          Explore collection
          <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
    </div>
    <div class="gc-season-card">
      <div class="gc-season-bg gc-rainy-bg"><div class="gc-season-illustration">🌧️</div></div>
      <div class="gc-season-overlay"></div>
      <div class="gc-season-content">
        <div class="gc-season-badge">🌧️ Rainy Season</div>
        <h3 class="gc-season-title">Rain-Resilient Crops</h3>
        <p class="gc-season-desc">Hardy varieties that flourish with monsoon rains and humid air.</p>
        <a href="plants.php?season=Rainy+Season" class="gc-season-link">
          Explore collection
          <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
    </div>
    <div class="gc-season-card">
      <div class="gc-season-bg gc-cold-bg"><div class="gc-season-illustration">❄️</div></div>
      <div class="gc-season-overlay"></div>
      <div class="gc-season-content">
        <div class="gc-season-badge">❄️ Cold Season</div>
        <h3 class="gc-season-title">Cool-Climate Greens</h3>
        <p class="gc-season-desc">Crisp leafy greens and root vegetables that love the cooler months.</p>
        <a href="plants.php?season=Cold+Season" class="gc-season-link">
          Explore collection
          <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- FEATURES STRIP -->
<div class="gc-features-strip">
  <div class="gc-features-inner">
    <div class="gc-feature">
      <div class="gc-feature-icon">🌱</div>
      <h3 class="gc-feature-title">Seasonal Guidance</h3>
      <p class="gc-feature-desc">Curated seed selections tailored for Myanmar's three growing seasons, so you always plant at the right time.</p>
    </div>
    <div class="gc-feature">
      <div class="gc-feature-icon">🛒</div>
      <h3 class="gc-feature-title">Easy Ordering</h3>
      <p class="gc-feature-desc">Add seeds to your cart, choose a payment method, and get your order delivered to your door.</p>
    </div>
    <div class="gc-feature">
      <div class="gc-feature-icon">🤝</div>
      <h3 class="gc-feature-title">Community Feedback</h3>
      <p class="gc-feature-desc">Read and share real grower experiences to help everyone in the community grow better.</p>
    </div>
  </div>
</div>

<?php include('includes/footer.php'); ?>