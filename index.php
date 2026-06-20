<?php
session_start();
include('includes/header.php'); ?>

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
  <!-- Botanical SVG drawn on load — signature element -->
  <svg class="gc-botanical" viewBox="0 0 500 600" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
    <path class="gc-bot-path p1" d="M250 580 C250 400 180 300 120 200" stroke="#3B6B47" stroke-width="1.5" stroke-linecap="round"/>
    <path class="gc-bot-path p2" d="M120 200 C80 140 60 80 90 30" stroke="#3B6B47" stroke-width="1.5" stroke-linecap="round"/>
    <path class="gc-bot-path p3" d="M180 320 C140 290 100 295 70 310 C110 330 150 335 180 320Z" stroke="#3B6B47" stroke-width="1.2" fill="rgba(59,107,71,0.08)" stroke-linecap="round" stroke-linejoin="round"/>
    <path class="gc-bot-path p4" d="M210 240 C170 200 130 205 100 230 C140 248 185 248 210 240Z" stroke="#3B6B47" stroke-width="1.2" fill="rgba(59,107,71,0.08)" stroke-linecap="round" stroke-linejoin="round"/>
    <path class="gc-bot-path p5" d="M235 170 C200 130 165 130 145 155 C178 172 215 170 235 170Z" stroke="#3B6B47" stroke-width="1.2" fill="rgba(59,107,71,0.08)" stroke-linecap="round" stroke-linejoin="round"/>
    <path class="gc-bot-path p6" d="M245 105 C230 70 210 55 195 65 C205 88 228 100 245 105Z" stroke="#3B6B47" stroke-width="1.2" fill="rgba(59,107,71,0.08)" stroke-linecap="round" stroke-linejoin="round"/>
    <!-- right side branch -->
    <path class="gc-bot-path p7" d="M225 290 C265 260 300 268 320 290 C285 308 248 305 225 290Z" stroke="#3B6B47" stroke-width="1.2" fill="rgba(59,107,71,0.08)" stroke-linecap="round" stroke-linejoin="round"/>
    <path class="gc-bot-path p8" d="M238 210 C275 185 308 195 325 218 C292 232 255 228 238 210Z" stroke="#3B6B47" stroke-width="1.2" fill="rgba(59,107,71,0.08)" stroke-linecap="round" stroke-linejoin="round"/>
  </svg>

  <div class="gc-hero-content">
    <!-- LEFT: text -->
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
          <strong>120+</strong>
          <span>Varieties</span>
        </div>
        <div class="gc-stat-divider"></div>
        <div class="gc-stat">
          <strong>3</strong>
          <span>Seasons</span>
        </div>
        <div class="gc-stat-divider"></div>
        <div class="gc-stat">
          <strong>100%</strong>
          <span>Local</span>
        </div>
      </div>
    </div>

    <!-- RIGHT: featured plant card + season grid -->
    <div class="gc-right-panel">
      <div class="gc-featured-card">
        <div class="gc-fc-head">
          <div class="gc-fc-tag">☀️ Hot Season Pick</div>
          <div class="gc-fc-price">2,500 <span>MMK</span></div>
        </div>
        <h3 class="gc-fc-name">Thai Basil Seeds</h3>
        <p class="gc-fc-latin">Ocimum basilicum var. thyrsiflora</p>
        <div class="gc-fc-bars">
          <div class="gc-bar-row">
            <span class="gc-bar-label">Difficulty</span>
            <div class="gc-bar-track"><div class="gc-bar-fill" style="--w:25%"></div></div>
            <span class="gc-bar-val">Easy</span>
          </div>
          <div class="gc-bar-row">
            <span class="gc-bar-label">Sunlight</span>
            <div class="gc-bar-track"><div class="gc-bar-fill" style="--w:90%"></div></div>
            <span class="gc-bar-val">Full</span>
          </div>
          <div class="gc-bar-row">
            <span class="gc-bar-label">Harvest</span>
            <div class="gc-bar-track"><div class="gc-bar-fill" style="--w:55%"></div></div>
            <span class="gc-bar-val">45–60d</span>
          </div>
        </div>
        <div class="gc-fc-foot">
          <div class="gc-fc-chips">
            <span class="gc-chip">Aromatic</span>
            <span class="gc-chip">Edible</span>
          </div>
          <a href="cart.php" class="gc-fc-btn">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
            Add to cart
          </a>
        </div>
      </div>

      <div class="gc-season-grid">
        <a href="plants.php?season=Hot+Season" class="gc-smini gc-sm-hot">
          <span class="gc-smini-icon">☀️</span>
          <strong>Hot Season</strong>
          <span>38 varieties</span>
          <svg class="gc-smini-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
        <a href="plants.php?season=Rainy+Season" class="gc-smini gc-sm-rainy">
          <span class="gc-smini-icon">🌧️</span>
          <strong>Rainy Season</strong>
          <span>45 varieties</span>
          <svg class="gc-smini-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
        <a href="plants.php?season=Cold+Season" class="gc-smini gc-sm-cold">
          <span class="gc-smini-icon">❄️</span>
          <strong>Cold Season</strong>
          <span>37 varieties</span>
          <svg class="gc-smini-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
        <a href="plants.php" class="gc-smini gc-sm-all">
          <span class="gc-smini-icon">🌿</span>
          <strong>All Seasons</strong>
          <span>View all 120+</span>
          <svg class="gc-smini-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
      </div>
    </div>
  </div>
</section>

<!-- SEASONS SECTION -->
<section class="gc-seasons-wrap">
  <div class="gc-seasons-header">
    <p class="gc-section-eye">Browse by season</p>
    <h2 class="gc-section-title">What grows in<br><em>your climate?</em></h2>
  </div>
  <div class="gc-seasons-grid">
    <a href="plants.php?season=Hot+Season" class="gc-scard gc-scard-hot gc-reveal" data-dir="left">
      <div class="gc-scard-bg"></div>
      <div class="gc-scard-body">
        <span class="gc-scard-icon">☀️</span>
        <h3>Heat-Loving Plants</h3>
        <p>Bold flavors, vivid colors — seeds that thrive when the sun is strongest.</p>
        <span class="gc-scard-cta">Explore <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" width="14" height="14"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
      </div>
    </a>
    <a href="plants.php?season=Rainy+Season" class="gc-scard gc-scard-rain gc-reveal" data-dir="up">
      <div class="gc-scard-bg"></div>
      <div class="gc-scard-body">
        <span class="gc-scard-icon">🌧️</span>
        <h3>Rain-Resilient Crops</h3>
        <p>Hardy varieties that flourish when the monsoon arrives and the soil is alive.</p>
        <span class="gc-scard-cta">Explore <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" width="14" height="14"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
      </div>
    </a>
    <a href="plants.php?season=Cold+Season" class="gc-scard gc-scard-cold gc-reveal" data-dir="right">
      <div class="gc-scard-bg"></div>
      <div class="gc-scard-body">
        <span class="gc-scard-icon">❄️</span>
        <h3>Cool-Climate Greens</h3>
        <p>Crisp leafy greens and roots that love the cooler months and open air.</p>
        <span class="gc-scard-cta">Explore <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" width="14" height="14"><path d="M5 12h14M12 5l7 7-7 7"/></svg></span>
      </div>
    </a>
  </div>
</section>

<!-- FEATURES STRIP -->
<div class="gc-features">
  <div class="gc-features-inner">
    <div class="gc-feat gc-reveal" data-dir="up">
      <div class="gc-feat-num">01</div>
      <h3>Seasonal Guidance</h3>
      <p>Every seed is chosen for a specific season in Myanmar — never guesswork, always intentional.</p>
    </div>
    <div class="gc-feat gc-reveal" data-dir="up" style="--delay:80ms">
      <div class="gc-feat-num">02</div>
      <h3>Simple Ordering</h3>
      <p>Add to cart, checkout in minutes, delivered to your door — no friction between you and growing.</p>
    </div>
    <div class="gc-feat gc-reveal" data-dir="up" style="--delay:160ms">
      <div class="gc-feat-num">03</div>
      <h3>Grower Community</h3>
      <p>Real feedback from real gardeners — help everyone in the community grow a little better.</p>
    </div>
  </div>
</div>

<?php include('includes/footer.php'); ?>
