/**
 * Garden Companion — gc_animations.js
 * Place in assets/js/ and add to header.php:
 * <script src="assets/js/gc_animations.js" defer></script>
 */

(function () {
  'use strict';

  // ── Scroll reveal via IntersectionObserver ──────────────────
  const revealEls = document.querySelectorAll('.gc-reveal');

  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('is-visible');
            observer.unobserve(entry.target); // fire once
          }
        });
      },
      { threshold: 0.15, rootMargin: '0px 0px -40px 0px' }
    );

    revealEls.forEach((el) => observer.observe(el));
  } else {
    // Fallback: show everything immediately
    revealEls.forEach((el) => el.classList.add('is-visible'));
  }

  // ── Pause looping botanical SVG off-screen ─────────────────
  const botanical = document.querySelector('.gc-botanical');
  if (botanical && 'IntersectionObserver' in window) {
    const botObserver = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          botanical.style.animationPlayState = entry.isIntersecting
            ? 'running'
            : 'paused';
        });
      },
      { threshold: 0 }
    );
    botObserver.observe(botanical);
  }

  // ── Season card bar: re-trigger if scrolled past ───────────
  // (bars are CSS animation, already handled by prefers-reduced-motion)

})();