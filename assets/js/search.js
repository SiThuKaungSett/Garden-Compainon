/**
 * Garden Companion — search.js (redesigned dropdown)
 * Place in assets/js/search.js
 */
document.addEventListener("DOMContentLoaded", function () {
  const searchBox     = document.getElementById("searchBox");
  const searchResults = document.getElementById("searchResults");

  if (!searchBox || !searchResults) return;

  let debounceTimer = null;

  /* ── helpers ──────────────────────────────────────────── */
  function openDropdown() {
    searchResults.style.display = "block";
    // next frame so display:block is painted before transition fires
    requestAnimationFrame(() => searchResults.classList.add("gc-open"));
  }

  function closeDropdown() {
    searchResults.classList.remove("gc-open");
    // wait for CSS transition to finish before hiding
    setTimeout(() => { searchResults.style.display = "none"; }, 180);
  }

  function renderResults(data) {
    searchResults.innerHTML = "";

    if (data.length === 0) {
      const empty = document.createElement("li");
      empty.className = "gc-no-results";
      empty.textContent = "No plants found";
      searchResults.appendChild(empty);
      openDropdown();
      return;
    }

    data.forEach((item, index) => {
      const li = document.createElement("li");
      li.className = "search-item";
      li.tabIndex = 0;                          // keyboard accessible
      li.setAttribute("role", "option");
      li.setAttribute("aria-label", item.name);
      li.setAttribute("data-id", item.p_id);

      // thumbnail
      const img = document.createElement("img");
      img.src    = `uploads/${item.image}`;
      img.alt    = item.name;
      img.width  = 38;
      img.height = 38;
      img.loading = "lazy";
      img.onerror = () => {
        // fallback: show a leaf placeholder if image is missing
        img.style.display = "none";
        const fallback = document.createElement("div");
        fallback.style.cssText =
          "width:38px;height:38px;border-radius:8px;background:rgba(59,107,71,0.25);" +
          "display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;";
        fallback.textContent = "🌿";
        li.insertBefore(fallback, li.firstChild);
      };

      // name
      const name = document.createElement("span");
      name.textContent = item.name;

      li.appendChild(img);
      li.appendChild(name);

      // click & keyboard nav
      const navigate = () => {
        if (item.p_id) window.location.href = `moredetail.php?id=${item.p_id}`;
      };
      li.addEventListener("click", navigate);
      li.addEventListener("keydown", (e) => {
        if (e.key === "Enter" || e.key === " ") { e.preventDefault(); navigate(); }
        // arrow key nav between items
        if (e.key === "ArrowDown") {
          e.preventDefault();
          const next = li.nextElementSibling;
          if (next) next.focus();
        }
        if (e.key === "ArrowUp") {
          e.preventDefault();
          const prev = li.previousElementSibling;
          if (prev) prev.focus();
          else searchBox.focus();
        }
        if (e.key === "Escape") { closeDropdown(); searchBox.focus(); }
      });

      searchResults.appendChild(li);
    });

    openDropdown();
  }

  /* ── search input ─────────────────────────────────────── */
  searchBox.addEventListener("input", function () {
    clearTimeout(debounceTimer);
    const query = searchBox.value.trim();

    if (query.length === 0) { closeDropdown(); return; }

    // debounce: wait 200ms after typing stops
    debounceTimer = setTimeout(() => {
      fetch(`search.php?q=${encodeURIComponent(query)}`)
        .then((r) => r.json())
        .then(renderResults)
        .catch(() => {
          searchResults.innerHTML = "";
          const err = document.createElement("li");
          err.className = "gc-no-results";
          err.textContent = "Search unavailable";
          searchResults.appendChild(err);
          openDropdown();
        });
    }, 200);
  });

  /* Arrow-down from search box moves focus into first result */
  searchBox.addEventListener("keydown", function (e) {
    if (e.key === "ArrowDown") {
      e.preventDefault();
      const first = searchResults.querySelector(".search-item");
      if (first) first.focus();
    }
    if (e.key === "Escape") closeDropdown();
  });

  /* ── close on outside click ───────────────────────────── */
  document.addEventListener("click", function (e) {
    const bar = searchBox.closest(".gc-search-bar");
    if (bar && !bar.contains(e.target)) closeDropdown();
  });
});

/* ── toast helper (unchanged) ─────────────────────────── */
function showToast() {
  const toast = document.getElementById("toast");
  if (!toast) return;
  toast.classList.add("show");
  setTimeout(() => {
    toast.classList.remove("show");
    window.location.href = "adlogin.php";
  }, 2000);
}