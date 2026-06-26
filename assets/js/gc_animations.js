/**
 * Garden Companion — gc_animations.js  v2
 * assets/js/gc_animations.js
 * Handles: scroll reveal, parallax, counter, marquee pause, search dropdown
 */
(function () {
  'use strict';

  /* ── 1. SCROLL REVEAL ───────────────────────────────────── */
  const revealEls = document.querySelectorAll('.gc-reveal');
  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver(
      (entries) => entries.forEach((e) => {
        if (e.isIntersecting) { e.target.classList.add('is-visible'); observer.unobserve(e.target); }
      }),
      { threshold: 0.12, rootMargin: '0px 0px -40px 0px' }
    );
    revealEls.forEach((el) => observer.observe(el));
  } else {
    revealEls.forEach((el) => el.classList.add('is-visible'));
  }

  /* ── 2. PARALLAX ────────────────────────────────────────── */
  const parallaxBg = document.getElementById('gc-parallax-bg');
  if (parallaxBg) {
    let ticking = false;
    const onScroll = () => {
      if (!ticking) {
        window.requestAnimationFrame(() => {
          // Only transform — no layout props, stays on compositor thread
          const y = window.scrollY * 0.35;
          parallaxBg.style.transform = `translateY(${y}px)`;
          ticking = false;
        });
        ticking = true;
      }
    };
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  /* ── 3. COUNTER ANIMATION ───────────────────────────────── */
  const counters = document.querySelectorAll('.gc-counter');
  if (counters.length && 'IntersectionObserver' in window) {
    const countUp = (el) => {
      const target = parseInt(el.dataset.target, 10);
      const suffix = el.dataset.suffix || '+';
      const duration = 1200; // ms
      const start = performance.now();
      const tick = (now) => {
        const elapsed = now - start;
        const progress = Math.min(elapsed / duration, 1);
        // ease-out-quart
        const eased = 1 - Math.pow(1 - progress, 4);
        el.textContent = Math.floor(eased * target) + suffix;
        if (progress < 1) requestAnimationFrame(tick);
      };
      requestAnimationFrame(tick);
    };

    const statsObserver = new IntersectionObserver(
      (entries) => entries.forEach((e) => {
        if (e.isIntersecting) { countUp(e.target); statsObserver.unobserve(e.target); }
      }),
      { threshold: 0.5 }
    );
    counters.forEach((el) => statsObserver.observe(el));
  } else {
    // Fallback — show final value immediately
    counters.forEach((el) => {
      el.textContent = el.dataset.target + (el.dataset.suffix || '+');
    });
  }

  /* ── 4. BOTANICAL SVG — pause off-screen ────────────────── */
  const botanical = document.querySelector('.gc-botanical');
  if (botanical && 'IntersectionObserver' in window) {
    const botObs = new IntersectionObserver(
      (entries) => entries.forEach((e) => {
        botanical.style.animationPlayState = e.isIntersecting ? 'running' : 'paused';
      }),
      { threshold: 0 }
    );
    botObs.observe(botanical);
  }

  /* ── 5. SEARCH DROPDOWN ─────────────────────────────────── */
  const searchBox     = document.getElementById('searchBox');
  const searchResults = document.getElementById('searchResults');

  if (searchBox && searchResults) {
    let debounce = null;

    function openDrop() {
      searchResults.style.display = 'block';
      requestAnimationFrame(() => searchResults.classList.add('gc-open'));
    }
    function closeDrop() {
      searchResults.classList.remove('gc-open');
      setTimeout(() => { searchResults.style.display = 'none'; }, 180);
    }
    function renderResults(data) {
      searchResults.innerHTML = '';
      if (!data.length) {
        const li = document.createElement('li');
        li.className = 'gc-no-results'; li.textContent = 'No plants found';
        searchResults.appendChild(li); openDrop(); return;
      }
      data.forEach((item) => {
        const li = document.createElement('li');
        li.className = 'search-item'; li.tabIndex = 0;
        li.setAttribute('data-id', item.p_id);

        const img = document.createElement('img');
        img.src = `uploads/${item.image}`; img.alt = item.name;
        img.width = 46; img.height = 46;
        img.onerror = () => {
          img.style.display = 'none';
          const fb = document.createElement('div');
          fb.style.cssText = 'width:46px;height:46px;border-radius:9px;background:rgba(59,107,71,0.25);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;';
          fb.textContent = '🌿'; li.insertBefore(fb, li.firstChild);
        };
        const name = document.createElement('span'); name.textContent = item.name;
        li.appendChild(img); li.appendChild(name);

        const go = () => { if (item.p_id) window.location.href = `moredetail.php?id=${item.p_id}`; };
        li.addEventListener('click', go);
        li.addEventListener('keydown', (e) => {
          if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); go(); }
          if (e.key === 'ArrowDown') { e.preventDefault(); const n = li.nextElementSibling; if (n) n.focus(); }
          if (e.key === 'ArrowUp')   { e.preventDefault(); const p = li.previousElementSibling; if (p) p.focus(); else searchBox.focus(); }
          if (e.key === 'Escape')    { closeDrop(); searchBox.focus(); }
        });
        searchResults.appendChild(li);
      });
      openDrop();
    }

    searchBox.addEventListener('input', () => {
      clearTimeout(debounce);
      const q = searchBox.value.trim();
      if (!q) { closeDrop(); return; }
      debounce = setTimeout(() => {
        fetch(`search.php?q=${encodeURIComponent(q)}`)
          .then(r => r.json()).then(renderResults)
          .catch(() => {
            searchResults.innerHTML = '<li class="gc-no-results">Search unavailable</li>';
            openDrop();
          });
      }, 200);
    });

    searchBox.addEventListener('keydown', (e) => {
      if (e.key === 'ArrowDown') { e.preventDefault(); const f = searchResults.querySelector('.search-item'); if (f) f.focus(); }
      if (e.key === 'Escape') closeDrop();
    });

    document.addEventListener('click', (e) => {
      const bar = searchBox.closest('.gc-search-bar');
      if (bar && !bar.contains(e.target)) closeDrop();
    });
  }

  /* ── 6. REDUCED MOTION: disable counter + parallax ─────── */
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
    counters.forEach((el) => { el.textContent = el.dataset.target + (el.dataset.suffix || '+'); });
    if (parallaxBg) parallaxBg.style.transform = 'none';
  }

})();

/* ── Toast helper (global) ──────────────────────────────── */
function showToast() {
  const toast = document.getElementById('toast');
  if (!toast) return;
  toast.classList.add('show');
  setTimeout(() => { toast.classList.remove('show'); window.location.href = 'adlogin.php'; }, 2000);
}