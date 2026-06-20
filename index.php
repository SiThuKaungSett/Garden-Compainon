<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Garden Companion</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { font-size: 16px; scroll-behavior: smooth; }

body {
  background: #F4F1EA;
  color: #2A2A24;
  font-family: 'Inter', sans-serif;
}

/* NAV */
nav {
  display: flex; align-items: center; justify-content: space-between;
  padding: 0 56px; height: 68px;
  background: #F4F1EA;
  border-bottom: 1px solid rgba(42,42,36,0.1);
  position: sticky; top: 0; z-index: 100;
}
.nav-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
.nav-logo img { height: 36px; width: auto; }
.nav-logo-text {
  font-family: 'Lora', serif; font-size: 17px; font-weight: 600;
  color: #2A2A24; letter-spacing: -0.2px;
}
.nav-links { display: flex; gap: 4px; list-style: none; }
.nav-links a {
  font-size: 14px; font-weight: 400; color: #6B6B5E;
  text-decoration: none; padding: 7px 16px; border-radius: 6px;
  transition: all 0.2s;
}
.nav-links a:hover { color: #2A2A24; background: rgba(42,42,36,0.06); }
.nav-links li.active a { color: #3E6B47; font-weight: 500; }

.nav-right { display: flex; align-items: center; gap: 10px; }
.search-wrap {
  display: flex; align-items: center; gap: 8px;
  background: #EDE9DF; border: 1px solid rgba(42,42,36,0.1);
  border-radius: 8px; padding: 8px 14px;
}
.search-wrap svg { color: #9A9A8E; flex-shrink: 0; }
.search-wrap input {
  background: none; border: none; outline: none;
  font-family: 'Inter', sans-serif; font-size: 13px;
  color: #2A2A24; width: 140px;
}
.search-wrap input::placeholder { color: #9A9A8E; }
.icon-btn {
  width: 38px; height: 38px; border-radius: 8px;
  border: 1px solid rgba(42,42,36,0.1); background: #EDE9DF;
  display: flex; align-items: center; justify-content: center;
  color: #6B6B5E; text-decoration: none; transition: all 0.2s;
}
.icon-btn:hover { color: #2A2A24; background: #E5E0D4; }

/* HERO */
.hero {
  display: grid; grid-template-columns: 1fr 1fr;
  min-height: calc(100vh - 68px);
}
.hero-left {
  padding: 80px 64px 80px 56px;
  display: flex; flex-direction: column; justify-content: center;
  border-right: 1px solid rgba(42,42,36,0.1);
}
.hero-season-tag {
  display: inline-flex; align-items: center; gap: 7px;
  background: #E8F0E4; color: #3E6B47;
  font-size: 12px; font-weight: 500; letter-spacing: 0.3px;
  padding: 5px 12px; border-radius: 20px; margin-bottom: 32px;
  width: fit-content;
}
.hero-season-tag span { width: 6px; height: 6px; background: #5A9465; border-radius: 50%; }

.hero-title {
  font-family: 'Lora', serif;
  font-size: clamp(36px, 4vw, 56px);
  font-weight: 600; line-height: 1.18;
  color: #1E1E18; letter-spacing: -0.5px;
  margin-bottom: 24px;
}
.hero-title em { font-style: italic; color: #3E6B47; }

.hero-body {
  font-size: 16px; line-height: 1.8; color: #6B6B5E;
  font-weight: 300; max-width: 420px; margin-bottom: 40px;
}

.hero-btns { display: flex; align-items: center; gap: 14px; flex-wrap: wrap; margin-bottom: 56px; }

.btn-primary {
  background: #3E6B47; color: #fff;
  padding: 12px 26px; border-radius: 8px;
  font-size: 14px; font-weight: 500; text-decoration: none;
  display: inline-flex; align-items: center; gap: 8px;
  transition: background 0.2s;
}
.btn-primary:hover { background: #2E5235; }

.btn-secondary {
  color: #3E6B47; border: 1.5px solid #C4D8C0;
  padding: 11px 24px; border-radius: 8px;
  font-size: 14px; font-weight: 500; text-decoration: none;
  transition: all 0.2s;
}
.btn-secondary:hover { background: #E8F0E4; border-color: #A8C8A0; }

.hero-stats {
  display: flex; gap: 36px;
  padding-top: 40px; border-top: 1px solid rgba(42,42,36,0.1);
}
.stat-item { display: flex; flex-direction: column; gap: 3px; }
.stat-num {
  font-family: 'Lora', serif; font-size: 28px; font-weight: 600;
  color: #2A2A24; line-height: 1;
}
.stat-label { font-size: 12px; color: #9A9A8E; font-weight: 400; }

/* Hero right — image-like panel with season cards stacked */
.hero-right {
  background: #EDE9DF;
  display: flex; flex-direction: column;
  padding: 48px 40px;
  gap: 16px; justify-content: center;
}

.season-preview-card {
  background: #F4F1EA; border: 1px solid rgba(42,42,36,0.1);
  border-radius: 12px; padding: 24px 28px;
  display: flex; align-items: center; gap: 20px;
  text-decoration: none; color: inherit;
  transition: all 0.2s;
}
.season-preview-card:hover {
  background: #fff; border-color: rgba(62,107,71,0.25);
  transform: translateX(4px);
}
.spc-icon {
  width: 52px; height: 52px; border-radius: 10px;
  display: flex; align-items: center; justify-content: center;
  font-size: 26px; flex-shrink: 0;
}
.spc-icon-hot  { background: #FEF3E2; }
.spc-icon-rain { background: #E6F0F8; }
.spc-icon-cold { background: #EEF2F8; }

.spc-text { flex: 1; }
.spc-name {
  font-family: 'Lora', serif; font-size: 16px; font-weight: 600;
  color: #2A2A24; margin-bottom: 4px;
}
.spc-desc { font-size: 12px; color: #9A9A8E; line-height: 1.5; }
.spc-count {
  font-size: 12px; font-weight: 500; color: #3E6B47;
  background: #E8F0E4; padding: 3px 10px; border-radius: 20px;
}

/* ABOUT STRIP */
.about-strip {
  display: grid; grid-template-columns: repeat(3, 1fr);
  border-top: 1px solid rgba(42,42,36,0.1);
  border-bottom: 1px solid rgba(42,42,36,0.1);
}
.about-cell {
  padding: 48px 52px;
  border-right: 1px solid rgba(42,42,36,0.1);
}
.about-cell:last-child { border-right: none; }
.about-icon {
  width: 40px; height: 40px; background: #E8F0E4; border-radius: 8px;
  display: flex; align-items: center; justify-content: center;
  font-size: 20px; margin-bottom: 18px;
}
.about-title {
  font-family: 'Lora', serif; font-size: 17px; font-weight: 600;
  color: #1E1E18; margin-bottom: 10px;
}
.about-desc { font-size: 14px; line-height: 1.75; color: #6B6B5E; font-weight: 300; }

/* SEASONS SECTION */
.seasons-section { padding: 88px 56px; }
.section-label {
  font-size: 11px; font-weight: 500; letter-spacing: 2px; text-transform: uppercase;
  color: #9A9A8E; margin-bottom: 12px;
}
.section-heading {
  font-family: 'Lora', serif; font-size: 36px; font-weight: 600;
  color: #1E1E18; letter-spacing: -0.3px; margin-bottom: 48px; line-height: 1.2;
}

.seasons-grid {
  display: grid; grid-template-columns: repeat(3, 1fr);
  gap: 20px;
}
.season-card {
  border-radius: 16px; overflow: hidden;
  border: 1px solid rgba(42,42,36,0.1);
  text-decoration: none; color: inherit;
  background: #EDEAD9;
  transition: transform 0.25s;
  display: flex; flex-direction: column;
}
.season-card:hover { transform: translateY(-4px); }

.season-card-top {
  height: 180px; display: flex; align-items: center;
  justify-content: center; font-size: 64px; position: relative;
}
.sc-top-hot  { background: #F7E8CC; }
.sc-top-rain { background: #CCE0EF; }
.sc-top-cold { background: #DCEAF5; }

.season-card-body { padding: 24px 26px 28px; flex: 1; display: flex; flex-direction: column; }
.sc-tag {
  font-size: 11px; font-weight: 500; letter-spacing: 1.5px;
  text-transform: uppercase; margin-bottom: 8px;
}
.sc-tag-hot  { color: #B07030; }
.sc-tag-rain { color: #3A6E8A; }
.sc-tag-cold { color: #4A6A8A; }

.sc-name {
  font-family: 'Lora', serif; font-size: 22px; font-weight: 600;
  color: #1E1E18; margin-bottom: 10px; line-height: 1.2;
}
.sc-desc {
  font-size: 13px; line-height: 1.7; color: #6B6B5E;
  font-weight: 300; margin-bottom: 20px; flex: 1;
}
.sc-plants {
  display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 20px;
}
.sc-plant {
  font-size: 11px; color: #6B6B5E;
  background: rgba(42,42,36,0.06); border-radius: 20px;
  padding: 3px 10px;
}
.sc-link {
  font-size: 13px; font-weight: 500; color: #3E6B47;
  display: flex; align-items: center; gap: 6px; margin-top: auto;
}
.sc-link svg { transition: transform 0.2s; }
.season-card:hover .sc-link svg { transform: translateX(4px); }

/* FOOTER */
footer {
  background: #2A2A24; color: #C8C4B8;
  padding: 64px 56px 40px;
  display: grid; grid-template-columns: 1.5fr 1fr 1fr;
  gap: 48px;
}
.footer-logo-text {
  font-family: 'Lora', serif; font-size: 20px; font-weight: 600;
  color: #F4F1EA; margin-bottom: 14px;
}
.footer-tagline {
  font-size: 13px; color: #8A8A7E; line-height: 1.75;
  font-weight: 300; max-width: 240px; margin-bottom: 28px;
}
.footer-socials { display: flex; gap: 8px; }
.f-soc {
  width: 34px; height: 34px; border: 1px solid rgba(200,196,184,0.15);
  border-radius: 6px; display: flex; align-items: center; justify-content: center;
  color: #8A8A7E; text-decoration: none; transition: all 0.2s;
}
.f-soc:hover { color: #C8C4B8; border-color: rgba(200,196,184,0.3); }
.footer-col h4 {
  font-size: 11px; font-weight: 500; letter-spacing: 2px; text-transform: uppercase;
  color: #F4F1EA; margin-bottom: 18px;
}
.footer-col ul { list-style: none; }
.footer-col ul li { margin-bottom: 10px; }
.footer-col ul li a {
  font-size: 13px; color: #8A8A7E; text-decoration: none;
  font-weight: 300; transition: color 0.2s;
}
.footer-col ul li a:hover { color: #C8C4B8; }
.footer-col address {
  font-style: normal; font-size: 13px; color: #8A8A7E;
  line-height: 1.9; font-weight: 300;
}
.footer-bottom {
  grid-column: 1 / -1; border-top: 1px solid rgba(200,196,184,0.1);
  padding-top: 28px; display: flex; justify-content: space-between; align-items: center;
}
.footer-bottom p { font-size: 12px; color: #6A6A5E; }

@media (max-width: 1024px) {
  .hero { grid-template-columns: 1fr; }
  .hero-right { display: none; }
  .seasons-grid { grid-template-columns: 1fr 1fr; }
  .about-strip { grid-template-columns: 1fr; }
  .about-cell { border-right: none; border-bottom: 1px solid rgba(42,42,36,0.1); padding: 36px 40px; }
  footer { grid-template-columns: 1fr 1fr; padding: 48px 40px 32px; }
  nav { padding: 0 24px; }
  .seasons-section { padding: 64px 24px; }
}
@media (max-width: 640px) {
  .nav-links { display: none; }
  .hero-left { padding: 52px 24px; }
  .seasons-grid { grid-template-columns: 1fr; }
  footer { grid-template-columns: 1fr; padding: 40px 24px 28px; }
}
</style>
</head>
<body>

<nav>
  <a href="index.php" class="nav-logo">
    <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
      <rect width="36" height="36" rx="8" fill="#E8F0E4"/>
      <path d="M18 30 C18 30 10 23 10 16 C10 11.58 13.58 8 18 8 C22.42 8 26 11.58 26 16 C26 23 18 30 18 30Z" fill="#3E6B47"/>
      <line x1="18" y1="9" x2="18" y2="30" stroke="#86B892" stroke-width="1" opacity="0.7"/>
      <path d="M18 16 C18 16 12 13 11 8" stroke="#86B892" stroke-width="0.9" stroke-linecap="round" opacity="0.7"/>
      <path d="M18 20 C18 20 24 16 25 11" stroke="#86B892" stroke-width="0.9" stroke-linecap="round" opacity="0.7"/>
    </svg>
    <span class="nav-logo-text">Garden Companion</span>
  </a>

  <ul class="nav-links">
    <li class="active"><a href="index.php">Home</a></li>
    <li><a href="plants.php">Plants</a></li>
    <li><a href="aboutus.php">About Us</a></li>
    <li><a href="feedback.php">Feedback</a></li>
  </ul>

  <div class="nav-right">
    <div class="search-wrap">
      <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
      <input type="search" id="searchBox" placeholder="Search plants…" maxlength="50">
    </div>
    <a href="cart.php" class="icon-btn" title="Cart">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
    </a>
    <a href="adlogin.php" class="icon-btn" title="Login">
      <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
    </a>
  </div>
</nav>

<!-- HERO -->
<section class="hero">
  <div class="hero-left">
    <div class="hero-season-tag">
      <span></span>
      Planting season is open
    </div>

    <h1 class="hero-title">
      The right seed for<br>
      every <em>season</em> in<br>
      your garden.
    </h1>

    <p class="hero-body">
      Seeds chosen for Myanmar's three growing seasons — hot, rainy, and cool. 
      Every variety is locally sourced so what you plant actually grows.
    </p>

    <div class="hero-btns">
      <a href="plants.php" class="btn-primary">
        Browse plants
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </a>
      <a href="feedback.php" class="btn-secondary">Read grower stories</a>
    </div>

    <div class="hero-stats">
      <div class="stat-item">
        <span class="stat-num">120+</span>
        <span class="stat-label">Plant varieties</span>
      </div>
      <div class="stat-item">
        <span class="stat-num">3</span>
        <span class="stat-label">Seasons covered</span>
      </div>
      <div class="stat-item">
        <span class="stat-num">100%</span>
        <span class="stat-label">Locally sourced</span>
      </div>
    </div>
  </div>

  <div class="hero-right">
    <a href="plants.php?season=Hot+Season" class="season-preview-card">
      <div class="spc-icon spc-icon-hot">☀️</div>
      <div class="spc-text">
        <div class="spc-name">Hot Season</div>
        <div class="spc-desc">Thai Basil · Chili · Moringa · Lemongrass</div>
      </div>
      <span class="spc-count">42 plants</span>
    </a>

    <a href="plants.php?season=Rainy+Season" class="season-preview-card">
      <div class="spc-icon spc-icon-rain">🌧️</div>
      <div class="spc-text">
        <div class="spc-name">Rainy Season</div>
        <div class="spc-desc">Water Spinach · Taro · Ginger · Turmeric</div>
      </div>
      <span class="spc-count">38 plants</span>
    </a>

    <a href="plants.php?season=Cold+Season" class="season-preview-card">
      <div class="spc-icon spc-icon-cold">❄️</div>
      <div class="spc-text">
        <div class="spc-name">Cool Season</div>
        <div class="spc-desc">Kale · Cabbage · Carrot · Lettuce</div>
      </div>
      <span class="spc-count">40 plants</span>
    </a>
  </div>
</section>

<!-- WHY US STRIP -->
<div class="about-strip">
  <div class="about-cell">
    <div class="about-icon">🌱</div>
    <h3 class="about-title">Seasonal guidance</h3>
    <p class="about-desc">Curated seed selections matched to Myanmar's three growing seasons, so you always plant at the right time.</p>
  </div>
  <div class="about-cell">
    <div class="about-icon">🛒</div>
    <h3 class="about-title">Easy ordering</h3>
    <p class="about-desc">Add seeds to your cart, choose your payment method, and get your order delivered to your door.</p>
  </div>
  <div class="about-cell">
    <div class="about-icon">🤝</div>
    <h3 class="about-title">Grower community</h3>
    <p class="about-desc">Read and share real growing experiences so everyone in the community grows a little better.</p>
  </div>
</div>

<!-- SEASONS -->
<section class="seasons-section">
  <div class="section-label">Browse by season</div>
  <h2 class="section-heading">What grows in your climate?</h2>

  <div class="seasons-grid">
    <a href="plants.php?season=Hot+Season" class="season-card">
      <div class="season-card-top sc-top-hot">☀️</div>
      <div class="season-card-body">
        <div class="sc-tag sc-tag-hot">Hot Season</div>
        <div class="sc-name">Heat-loving plants</div>
        <p class="sc-desc">Seeds that thrive under the tropical sun — bold flavours, vibrant growth, full sun all day.</p>
        <div class="sc-plants">
          <span class="sc-plant">Thai Basil</span>
          <span class="sc-plant">Chili Pepper</span>
          <span class="sc-plant">Moringa</span>
          <span class="sc-plant">Lemongrass</span>
        </div>
        <span class="sc-link">
          Explore collection
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </span>
      </div>
    </a>

    <a href="plants.php?season=Rainy+Season" class="season-card">
      <div class="season-card-top sc-top-rain">🌧️</div>
      <div class="season-card-body">
        <div class="sc-tag sc-tag-rain">Rainy Season</div>
        <div class="sc-name">Rain-resilient crops</div>
        <p class="sc-desc">Hardy varieties that flourish with monsoon rains and high humidity throughout the wet months.</p>
        <div class="sc-plants">
          <span class="sc-plant">Water Spinach</span>
          <span class="sc-plant">Taro</span>
          <span class="sc-plant">Ginger</span>
        </div>
        <span class="sc-link">
          Explore collection
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </span>
      </div>
    </a>

    <a href="plants.php?season=Cold+Season" class="season-card">
      <div class="season-card-top sc-top-cold">❄️</div>
      <div class="season-card-body">
        <div class="sc-tag sc-tag-cold">Cool Season</div>
        <div class="sc-name">Cool-climate greens</div>
        <p class="sc-desc">Crisp leafy greens and root vegetables that love the cooler, drier months of the year.</p>
        <div class="sc-plants">
          <span class="sc-plant">Kale</span>
          <span class="sc-plant">Cabbage</span>
          <span class="sc-plant">Carrot</span>
          <span class="sc-plant">Lettuce</span>
        </div>
        <span class="sc-link">
          Explore collection
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </span>
      </div>
    </a>
  </div>
</section>

<!-- FOOTER -->
<footer>
  <div>
    <div class="footer-logo-text">Garden Companion</div>
    <p class="footer-tagline">Helping growers in Myanmar find the right seeds for every season.</p>
    <div class="footer-socials">
      <a href="#" class="f-soc" aria-label="Facebook">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
      </a>
      <a href="#" class="f-soc" aria-label="Instagram">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>
      </a>
      <a href="#" class="f-soc" aria-label="TikTok">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"/></svg>
      </a>
      <a href="#" class="f-soc" aria-label="Telegram">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m22 2-7 20-4-9-9-4Z"/><path d="M22 2 11 13"/></svg>
      </a>
    </div>
  </div>

  <div class="footer-col">
    <h4>Links</h4>
    <ul>
      <li><a href="#">Blog</a></li>
      <li><a href="#">Pricing</a></li>
      <li><a href="#">Customer service</a></li>
      <li><a href="aboutus.php">About us</a></li>
    </ul>
  </div>

  <div class="footer-col">
    <h4>Address</h4>
    <address>
      Gawt Village<br>
      Thaton Township<br>
      Mon State, Myanmar
    </address>
  </div>

  <div class="footer-bottom">
    <p>© 2025 Garden Companion. All rights reserved.</p>
    <p>Made with care in Myanmar</p>
  </div>
</footer>

</body>
</html>