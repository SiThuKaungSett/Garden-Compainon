/**
 * Garden Companion — plants_animations.js
 * Place in assets/js/
 * Add to header.php: <script src="assets/js/plants_animations.js" defer></script>
 */
(function () {
  'use strict';

  /* ── Card scroll reveal ─────────────────────────────────── */
  const cards = document.querySelectorAll('.pl-card');

  if (cards.length) {
    if ('IntersectionObserver' in window) {
      const observer = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              entry.target.classList.add('gc-card-visible');
              observer.unobserve(entry.target);
            }
          });
        },
        { threshold: 0.08, rootMargin: '0px 0px -30px 0px' }
      );
      cards.forEach((card) => observer.observe(card));
    } else {
      // Fallback: show all immediately
      cards.forEach((card) => card.classList.add('gc-card-visible'));
    }
  }

  /* ── Search dropdown (same logic as index) ──────────────── */
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
      if (data.length === 0) {
        const li = document.createElement('li');
        li.className = 'gc-no-results';
        li.textContent = 'No plants found';
        searchResults.appendChild(li);
        openDrop(); return;
      }
      data.forEach((item) => {
        const li = document.createElement('li');
        li.className = 'search-item';
        li.tabIndex = 0;
        li.setAttribute('data-id', item.p_id);

        const img = document.createElement('img');
        img.src = `uploads/${item.image}`;
        img.alt = item.name;
        img.width = 46; img.height = 46;
        img.onerror = () => {
          img.style.display = 'none';
          const fb = document.createElement('div');
          fb.style.cssText = 'width:46px;height:46px;border-radius:9px;background:rgba(59,107,71,0.25);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;';
          fb.textContent = '🌿';
          li.insertBefore(fb, li.firstChild);
        };
        const name = document.createElement('span');
        name.textContent = item.name;
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
          .catch(() => { searchResults.innerHTML = '<li class="gc-no-results">Search unavailable</li>'; openDrop(); });
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

})();