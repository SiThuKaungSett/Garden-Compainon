<?php
session_start();
include('includes/header.php');

// Fetch one featured hot-season plant for the hero card
$featured_query = "SELECT p_id, p_name, p_image, price, season FROM plants WHERE season = 'Hot Season' ORDER BY RAND() LIMIT 1";
$featured_result = mysqli_query($con, $featured_query);
$featured = mysqli_fetch_assoc($featured_result);
?>

<!-- NAV -->
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
    <li class="active"><a href="index.php">Home</a></li>
    <li><a href="plants.php">Plants</a></li>
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
        <?php if ($cartCount > 0): ?><span class="gc-cart-badge"><?= $cartCount ?></span><?php endif; ?>
      </a>
      <a href="logout.php" class="gc-icon-btn" title="Logout"><i class='bx bx-log-out'></i></a>
    <?php else: ?>
      <a href="adlogin.php" class="gc-icon-btn" title="Login"><i class='bx bx-user-circle'></i></a>
    <?php endif; ?>
  </div>
</header>

<!-- HERO -->
<section class="gc-hero" id="gc-hero">
  <!-- parallax bg layer -->
  <div class="gc-hero-parallax" id="gc-parallax-bg">
    <!-- botanical SVG -->
    <svg class="gc-botanical" viewBox="0 0 500 600" fill="none" aria-hidden="true">
      <path class="gc-bot-path p1" d="M250 580 C250 400 180 300 120 200" stroke="#3B6B47" stroke-width="1.5" stroke-linecap="round"/>
      <path class="gc-bot-path p2" d="M120 200 C80 140 60 80 90 30" stroke="#3B6B47" stroke-width="1.5" stroke-linecap="round"/>
      <path class="gc-bot-path p3" d="M180 320 C140 290 100 295 70 310 C110 330 150 335 180 320Z" stroke="#3B6B47" stroke-width="1.2" fill="rgba(59,107,71,0.08)" stroke-linecap="round" stroke-linejoin="round"/>
      <path class="gc-bot-path p4" d="M210 240 C170 200 130 205 100 230 C140 248 185 248 210 240Z" stroke="#3B6B47" stroke-width="1.2" fill="rgba(59,107,71,0.08)" stroke-linecap="round" stroke-linejoin="round"/>
      <path class="gc-bot-path p5" d="M235 170 C200 130 165 130 145 155 C178 172 215 170 235 170Z" stroke="#3B6B47" stroke-width="1.2" fill="rgba(59,107,71,0.08)" stroke-linecap="round" stroke-linejoin="round"/>
      <path class="gc-bot-path p6" d="M245 105 C230 70 210 55 195 65 C205 88 228 100 245 105Z" stroke="#3B6B47" stroke-width="1.2" fill="rgba(59,107,71,0.08)" stroke-linecap="round" stroke-linejoin="round"/>
      <path class="gc-bot-path p7" d="M225 290 C265 260 300 268 320 290 C285 308 248 305 225 290Z" stroke="#3B6B47" stroke-width="1.2" fill="rgba(59,107,71,0.08)" stroke-linecap="round" stroke-linejoin="round"/>
      <path class="gc-bot-path p8" d="M238 210 C275 185 308 195 325 218 C292 232 255 228 238 210Z" stroke="#3B6B47" stroke-width="1.2" fill="rgba(59,107,71,0.08)" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
  </div>

  <div class="gc-hero-content">
    <!-- LEFT -->
    <div class="gc-hero-text">
      <p class="gc-eyebrow">Seasonal Seeds · Myanmar</p>
      <h1 class="gc-hero-title">
        <span class="gc-line">Grow what</span>
        <span class="gc-line"><em>belongs</em> here.</span>
      </h1>
      <p class="gc-hero-desc">Seeds chosen for Myanmar's three seasons — so everything you plant grows the way nature intended it to.</p>
      <div class="gc-hero-actions">
        <a href="plants.php" class="gc-btn-primary">Browse plants</a>
        <a href="feedback.php" class="gc-btn-ghost">Share your story</a>
      </div>
      <div class="gc-hero-stats">
        <div class="gc-stat">
          <strong class="gc-counter" data-target="120">0</strong>
          <span>Varieties</span>
        </div>
        <div class="gc-stat-divider"></div>
        <div class="gc-stat">
          <strong class="gc-counter" data-target="3">0</strong>
          <span>Seasons</span>
        </div>
        <div class="gc-stat-divider"></div>
        <div class="gc-stat">
          <strong class="gc-counter" data-target="100" data-suffix="%">0</strong>
          <span>Local</span>
        </div>
      </div>
    </div>

    <!-- RIGHT — product card matching plants.php style -->
    <div class="gc-right-panel">
      <?php if ($featured): ?>
      <!-- Featured plant card — same visual language as pl-card -->
      <a href="moredetail.php?id=<?= $featured['p_id'] ?>" class="gc-hero-pcard gc-float">
        <div class="gc-hpc-img">
          <img src="uploads/<?= htmlspecialchars($featured['p_image']) ?>"
               alt="<?= htmlspecialchars($featured['p_name']) ?>"
               loading="eager">
          <span class="gc-hpc-badge">☀️ Hot Season Pick</span>
          <div class="gc-hpc-overlay"></div>
        </div>
        <div class="gc-hpc-body">
          <div class="gc-hpc-head">
            <p class="gc-hpc-name"><?= htmlspecialchars($featured['p_name']) ?></p>
            <span class="gc-hpc-price"><?= number_format($featured['price']) ?> <small>MMK</small></span>
          </div>
          <span class="gc-hpc-cta">
            View plant
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </span>
        </div>
      </a>
      <?php else: ?>
      <!-- Fallback if no hot season plants -->
      <a href="plants.php" class="gc-hero-pcard gc-float">
        <div class="gc-hpc-img gc-hpc-placeholder">
          <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="rgba(237,233,225,0.2)" stroke-width="1.5" stroke-linecap="round"><path d="M12 22V12M12 12C12 7 17 3 22 3C22 8 18 12 12 12ZM12 12C12 7 7 3 2 3C2 8 6 12 12 12Z"/></svg>
        </div>
        <div class="gc-hpc-body">
          <p class="gc-hpc-name">Explore Plants</p>
          <span class="gc-hpc-cta">Browse all <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
        </div>
      </a>
      <?php endif; ?>

      <!-- Season quick-access grid -->
      <div class="gc-season-grid">
        <a href="plants.php?season=Hot+Season" class="gc-smini gc-sm-hot">
          <div class="gc-sm-glow"></div>
          <span class="gc-smini-icon">☀️</span>
          <strong>Hot Season</strong>
          <span>38 varieties</span>
          <svg class="gc-smini-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
        <a href="plants.php?season=Rainy+Season" class="gc-smini gc-sm-rainy">
          <div class="gc-sm-glow"></div>
          <span class="gc-smini-icon">🌧️</span>
          <strong>Rainy Season</strong>
          <span>45 varieties</span>
          <svg class="gc-smini-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
        <a href="plants.php?season=Cold+Season" class="gc-smini gc-sm-cold">
          <div class="gc-sm-glow"></div>
          <span class="gc-smini-icon">❄️</span>
          <strong>Cold Season</strong>
          <span>37 varieties</span>
          <svg class="gc-smini-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
        <a href="plants.php" class="gc-smini gc-sm-all">
          <div class="gc-sm-glow"></div>
          <span class="gc-smini-icon">🌿</span>
          <strong>All Seasons</strong>
          <span>View all 120+</span>
          <svg class="gc-smini-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- MARQUEE TICKER -->
<div class="gc-marquee-wrap" aria-hidden="true">
  <div class="gc-marquee-track">
    <span>Hot Season Seeds</span><span class="gc-marquee-dot">✦</span>
    <span>Rainy Season Crops</span><span class="gc-marquee-dot">✦</span>
    <span>Cold Season Greens</span><span class="gc-marquee-dot">✦</span>
    <span>Locally Grown</span><span class="gc-marquee-dot">✦</span>
    <span>120+ Varieties</span><span class="gc-marquee-dot">✦</span>
    <span>Myanmar Seeds</span><span class="gc-marquee-dot">✦</span>
    <span>Seasonal Planting</span><span class="gc-marquee-dot">✦</span>
    <span>Hot Season Seeds</span><span class="gc-marquee-dot">✦</span>
    <span>Rainy Season Crops</span><span class="gc-marquee-dot">✦</span>
    <span>Cold Season Greens</span><span class="gc-marquee-dot">✦</span>
    <span>Locally Grown</span><span class="gc-marquee-dot">✦</span>
    <span>120+ Varieties</span><span class="gc-marquee-dot">✦</span>
    <span>Myanmar Seeds</span><span class="gc-marquee-dot">✦</span>
    <span>Seasonal Planting</span><span class="gc-marquee-dot">✦</span>
  </div>
</div>

<!-- SEASONS SECTION -->
<section class="gc-seasons-wrap">
  <div class="gc-seasons-header">
    <p class="gc-section-eye gc-reveal" data-dir="up">Browse by season</p>
    <h2 class="gc-section-title gc-reveal" data-dir="up" style="--delay:80ms">What grows in<br><em>your climate?</em></h2>
  </div>
  <div class="gc-seasons-grid">

    <!-- HOT — SVG illustrated scene -->
    <a href="plants.php?season=Hot+Season" class="gc-scard gc-scard-hot gc-reveal" data-dir="left" aria-label="Explore Hot Season plants">
      <div class="gc-scard-bg"></div>
      <svg class="gc-scard-pattern" viewBox="0 0 400 400" fill="none" aria-hidden="true">
        <g opacity="0.18" stroke="#FFD580" stroke-width="1">
          <line x1="200" y1="200" x2="200" y2="20"/><line x1="200" y1="200" x2="320" y2="80"/>
          <line x1="200" y1="200" x2="380" y2="200"/><line x1="200" y1="200" x2="320" y2="320"/>
          <line x1="200" y1="200" x2="200" y2="380"/><line x1="200" y1="200" x2="80" y2="320"/>
          <line x1="200" y1="200" x2="20" y2="200"/><line x1="200" y1="200" x2="80" y2="80"/>
          <line x1="200" y1="200" x2="260" y2="50"/><line x1="200" y1="200" x2="350" y2="140"/>
          <line x1="200" y1="200" x2="350" y2="260"/><line x1="200" y1="200" x2="260" y2="350"/>
          <line x1="200" y1="200" x2="140" y2="350"/><line x1="200" y1="200" x2="50" y2="260"/>
          <line x1="200" y1="200" x2="50" y2="140"/><line x1="200" y1="200" x2="140" y2="50"/>
        </g>
        <circle cx="200" cy="200" r="60" stroke="#FFD580" stroke-width="0.8" opacity="0.12"/>
        <circle cx="200" cy="200" r="110" stroke="#FFD580" stroke-width="0.5" opacity="0.08"/>
        <circle cx="200" cy="200" r="160" stroke="#FFD580" stroke-width="0.4" opacity="0.05"/>
      </svg>
      <div class="gc-scard-top">
        <span class="gc-scard-label">Hot Season</span>
        <span class="gc-scard-count">38 varieties</span>
      </div>
      <div class="gc-scard-body">
        <h3>Heat-Loving<br>Plants</h3>
        <p>Bold flavors, vivid colors — seeds that thrive when the sun is at its strongest.</p>
        <span class="gc-scard-cta">Explore collection <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" width="13" height="13"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
      </div>
    </a>

    <!-- RAINY — SVG illustrated scene -->
    <a href="plants.php?season=Rainy+Season" class="gc-scard gc-scard-rain gc-reveal" data-dir="up" style="--delay:100ms" aria-label="Explore Rainy Season plants">
      <div class="gc-scard-bg"></div>
      <svg class="gc-scard-pattern" viewBox="0 0 400 400" fill="none" aria-hidden="true">
        <g opacity="0.13" stroke="#A8CFEA" stroke-width="1" stroke-linecap="round">
          <line x1="60" y1="0" x2="20" y2="120"/><line x1="110" y1="0" x2="70" y2="130"/>
          <line x1="160" y1="0" x2="120" y2="140"/><line x1="210" y1="0" x2="170" y2="130"/>
          <line x1="260" y1="0" x2="220" y2="135"/><line x1="310" y1="0" x2="270" y2="125"/>
          <line x1="360" y1="0" x2="320" y2="130"/><line x1="85" y1="100" x2="45" y2="240"/>
          <line x1="135" y1="110" x2="95" y2="250"/><line x1="185" y1="105" x2="145" y2="255"/>
          <line x1="235" y1="100" x2="195" y2="250"/><line x1="285" y1="108" x2="245" y2="248"/>
          <line x1="335" y1="105" x2="295" y2="245"/><line x1="60" y1="220" x2="20" y2="380"/>
          <line x1="130" y1="230" x2="90" y2="400"/><line x1="200" y1="225" x2="160" y2="400"/>
          <line x1="270" y1="220" x2="230" y2="400"/><line x1="340" y1="228" x2="300" y2="400"/>
        </g>
        <g opacity="0.07" stroke="#A8CFEA" stroke-width="0.8" fill="none">
          <ellipse cx="120" cy="370" rx="30" ry="8"/><ellipse cx="120" cy="370" rx="50" ry="14"/>
          <ellipse cx="280" cy="380" rx="25" ry="7"/><ellipse cx="280" cy="380" rx="42" ry="12"/>
        </g>
      </svg>
      <div class="gc-scard-top">
        <span class="gc-scard-label">Rainy Season</span>
        <span class="gc-scard-count">45 varieties</span>
      </div>
      <div class="gc-scard-body">
        <h3>Rain-Resilient<br>Crops</h3>
        <p>Hardy varieties that flourish when the monsoon arrives and the soil is alive.</p>
        <span class="gc-scard-cta">Explore collection <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" width="13" height="13"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
      </div>
    </a>

    <!-- COLD — SVG illustrated scene -->
    <a href="plants.php?season=Cold+Season" class="gc-scard gc-scard-cold gc-reveal" data-dir="right" style="--delay:200ms" aria-label="Explore Cold Season plants">
      <div class="gc-scard-bg"></div>
      <svg class="gc-scard-pattern" viewBox="0 0 400 400" fill="none" aria-hidden="true">
        <g opacity="0.14" stroke="#B8D4E8" stroke-width="0.9" stroke-linecap="round" fill="none">
          <line x1="200" y1="120" x2="200" y2="280"/><line x1="120" y1="200" x2="280" y2="200"/>
          <line x1="143" y1="143" x2="257" y2="257"/><line x1="257" y1="143" x2="143" y2="257"/>
          <line x1="200" y1="152" x2="185" y2="167"/><line x1="200" y1="152" x2="215" y2="167"/>
          <line x1="200" y1="248" x2="185" y2="233"/><line x1="200" y1="248" x2="215" y2="233"/>
          <line x1="152" y1="200" x2="167" y2="185"/><line x1="152" y1="200" x2="167" y2="215"/>
          <line x1="248" y1="200" x2="233" y2="185"/><line x1="248" y1="200" x2="233" y2="215"/>
          <line x1="163" y1="163" x2="175" y2="175"/><line x1="237" y1="163" x2="225" y2="175"/>
          <line x1="163" y1="237" x2="175" y2="225"/><line x1="237" y1="237" x2="225" y2="225"/>
          <line x1="80" y1="80" x2="80" y2="120"/><line x1="60" y1="100" x2="100" y2="100"/>
          <line x1="320" y1="60" x2="320" y2="100"/><line x1="300" y1="80" x2="340" y2="80"/>
          <line x1="60" y1="310" x2="60" y2="350"/><line x1="40" y1="330" x2="80" y2="330"/>
          <line x1="330" y1="300" x2="330" y2="340"/><line x1="310" y1="320" x2="350" y2="320"/>
        </g>
        <circle cx="200" cy="200" r="45" stroke="#B8D4E8" stroke-width="0.6" opacity="0.08"/>
      </svg>
      <div class="gc-scard-top">
        <span class="gc-scard-label">Cold Season</span>
        <span class="gc-scard-count">37 varieties</span>
      </div>
      <div class="gc-scard-body">
        <h3>Cool-Climate<br>Greens</h3>
        <p>Crisp leafy greens and roots that love the cooler months and open air.</p>
        <span class="gc-scard-cta">Explore collection <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" width="13" height="13"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
      </div>
    </a>
  </div>
</section>

<!-- FEATURES STRIP -->
<div class="gc-features">
  <div class="gc-features-inner">
    <div class="gc-feat gc-reveal" data-dir="up">
      <div class="gc-feat-rule"></div>
      <h3>Seasonal Guidance</h3>
      <p>Every seed is chosen for a specific season in Myanmar — never guesswork, always intentional.</p>
    </div>
    <div class="gc-feat gc-reveal" data-dir="up" style="--delay:80ms">
      <div class="gc-feat-rule"></div>
      <h3>Simple Ordering</h3>
      <p>Add to cart, checkout in minutes, delivered to your door — no friction between you and growing.</p>
    </div>
    <div class="gc-feat gc-reveal" data-dir="up" style="--delay:160ms">
      <div class="gc-feat-rule"></div>
      <h3>Grower Community</h3>
      <p>Real feedback from real gardeners — help everyone in the community grow a little better.</p>
    </div>
  </div>
</div>

<?php include('includes/footer.php'); ?>