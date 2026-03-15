/* ==========================================================
   codex.js — הקודקס של השוליים
   Particle system · nav shadow · scroll reveals · card shimmer
   ========================================================== */

(function () {
  'use strict';

  /* ----------------------------------------------------------
     1. PARTICLE SYSTEM - drifting dust on #particle-canvas
     ---------------------------------------------------------- */
  const canvas = document.getElementById('particle-canvas');
  if (canvas) {
    const ctx = canvas.getContext('2d');
    let W, H, particles = [];

    function resize() {
      W = canvas.width  = canvas.offsetWidth;
      H = canvas.height = canvas.offsetHeight;
    }
    resize();
    window.addEventListener('resize', resize);

    const COUNT   = 80;
    const GOLD    = 'rgba(184,150,42,';
    const BLOOD   = 'rgba(122,21,21,';

    function mkParticle() {
      const useGold = Math.random() > 0.35;
      return {
        x:    Math.random() * W,
        y:    Math.random() * H,
        r:    Math.random() * 1.8 + 0.4,
        vx:   (Math.random() - 0.5) * 0.18,
        vy:   -(Math.random() * 0.35 + 0.05),
        a:    Math.random() * 0.55 + 0.1,
        da:   (Math.random() - 0.5) * 0.003,
        color: useGold ? GOLD : BLOOD,
      };
    }

    for (let i = 0; i < COUNT; i++) particles.push(mkParticle());

    function tick() {
      ctx.clearRect(0, 0, W, H);
      for (let p of particles) {
        p.x  += p.vx;
        p.y  += p.vy;
        p.a  += p.da;
        if (p.a <= 0.05) p.da =  Math.abs(p.da);
        if (p.a >= 0.65) p.da = -Math.abs(p.da);
        if (p.y < -4)  { p.y = H + 4; p.x = Math.random() * W; }
        if (p.x < -4)  p.x = W + 4;
        if (p.x > W + 4) p.x = -4;
        ctx.beginPath();
        ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
        ctx.fillStyle = p.color + p.a.toFixed(2) + ')';
        ctx.fill();
      }
      requestAnimationFrame(tick);
    }
    tick();
  }

  /* ----------------------------------------------------------
     2. NAV SCROLL SHADOW
     ---------------------------------------------------------- */
  const nav = document.getElementById('site-nav');
  if (nav) {
    function updateNav() {
      nav.classList.toggle('scrolled', window.scrollY > 20);
    }
    window.addEventListener('scroll', updateNav, { passive: true });
    updateNav();
  }

  /* ----------------------------------------------------------
     3. INTERSECTION OBSERVER - .reveal elements fade in
     Use threshold 0.05 + no negative rootMargin so elements
     already in viewport at page-load are caught immediately.
     rAF ensures layout is complete before first measure.
     ---------------------------------------------------------- */
  const revealEls = document.querySelectorAll('.reveal');
  if (revealEls.length) {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((e) => {
          if (e.isIntersecting) {
            e.target.classList.add('in');
            observer.unobserve(e.target);
          }
        });
      },
      { threshold: 0.05, rootMargin: '0px 0px 0px 0px' }
    );

    // Script runs in footer — DOM is complete. getBoundingClientRect forces
    // a synchronous reflow so we get accurate positions immediately.
    // Reveal anything already in the viewport, then let IntersectionObserver
    // handle the rest as the user scrolls.
    revealEls.forEach((el) => {
      const rect = el.getBoundingClientRect();
      if (rect.top < window.innerHeight && rect.bottom > 0) {
        el.classList.add('in');
      } else {
        observer.observe(el);
      }
    });
  }

  /* ----------------------------------------------------------
     4. HERO TITLE PARALLAX + GLOW PULSE
     ---------------------------------------------------------- */
  const heroTitle = document.querySelector('.hero-title');
  if (heroTitle) {
    window.addEventListener('scroll', () => {
      const y = window.scrollY;
      heroTitle.style.transform = `translateY(${y * 0.28}px)`;
      const glow = Math.max(0, 1 - y / 320);
      heroTitle.style.textShadow =
        `0 0 ${Math.round(24 * glow)}px rgba(184,150,42,${(0.6 * glow).toFixed(2)})`;
    }, { passive: true });
  }

  /* ----------------------------------------------------------
     5. CARD HOVER SHIMMER
     ---------------------------------------------------------- */
  document.querySelectorAll('.card').forEach((card) => {
    card.addEventListener('mousemove', (e) => {
      const r = card.getBoundingClientRect();
      const x = ((e.clientX - r.left) / r.width)  * 100;
      const y = ((e.clientY - r.top)  / r.height) * 100;
      card.style.setProperty('--shimmer-x', x + '%');
      card.style.setProperty('--shimmer-y', y + '%');
    });
    card.addEventListener('mouseleave', () => {
      card.style.removeProperty('--shimmer-x');
      card.style.removeProperty('--shimmer-y');
    });
  });

  /* ----------------------------------------------------------
     6. SMOOTH SCROLL for in-page anchor links
     ---------------------------------------------------------- */
  document.querySelectorAll('a[href^="#"]').forEach((a) => {
    a.addEventListener('click', (e) => {
      const target = document.querySelector(a.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });


  /* ----------------------------------------------------------
     7. STORY PAGE TURNER — sticky fixed bar
     ---------------------------------------------------------- */
  const storyBody = document.querySelector('.story-body');
  if (storyBody) {
    const pager = document.createElement('div');
    pager.className = 'story-pager';
    pager.innerHTML =
      '<button class="pager-btn pager-prev" disabled>← הקודם</button>' +
      '<span class="pager-info">עמוד <span class="pager-curr">1</span> / <span class="pager-tot">1</span></span>' +
      '<button class="pager-btn pager-next">הבא →</button>';
    // append to body so position:fixed works regardless of parent stacking
    document.body.appendChild(pager);
    // push page content up so last line isn't hidden behind the bar
    document.body.style.paddingBottom = '52px';

    const prevBtn = pager.querySelector('.pager-prev');
    const nextBtn = pager.querySelector('.pager-next');
    const currEl  = pager.querySelector('.pager-curr');
    const totEl   = pager.querySelector('.pager-tot');

    function getVH()    { return window.innerHeight; }
    function getPages() { return Math.max(1, Math.ceil(document.body.scrollHeight / getVH())); }
    function getCurr()  { return Math.floor(window.scrollY / getVH()) + 1; }

    function updatePager() {
      const c = getCurr(), t = getPages();
      currEl.textContent = c;
      totEl.textContent  = t;
      prevBtn.disabled   = c <= 1;
      nextBtn.disabled   = c >= t;
      // progress bar: gold→blood line across the top edge
      const pct = t > 1 ? ((c - 1) / (t - 1)) * 100 : 100;
      pager.style.setProperty('--pager-progress', pct.toFixed(1) + '%');
      // hide when story fits in a single screen
      pager.style.display = t <= 1 ? 'none' : 'flex';
    }

    prevBtn.addEventListener('click', () =>
      window.scrollTo({ top: (getCurr() - 2) * getVH(), behavior: 'smooth' }));
    nextBtn.addEventListener('click', () =>
      window.scrollTo({ top: getCurr() * getVH(), behavior: 'smooth' }));

    window.addEventListener('scroll', updatePager, { passive: true });
    window.addEventListener('resize', updatePager, { passive: true });
    requestAnimationFrame(updatePager);
  }

  /* ----------------------------------------------------------
     8. COMIC BOOK READER
     ---------------------------------------------------------- */
  (function () {
    const reader = document.getElementById('comic-reader');
    if (!reader) return;

    const pages  = Array.from(reader.querySelectorAll('.cv-page'));
    const prevBtn = reader.querySelector('#cvPrev');
    const nextBtn = reader.querySelector('#cvNext');
    const currEl  = reader.querySelector('#cvCurrent');
    const fsBtn   = reader.querySelector('#cvFullscreen');
    const total   = pages.length;
    let   current = 0;

    // Init — only first page visible
    pages.forEach((p, i) => { p.style.display = i === 0 ? 'block' : 'none'; });

    function goTo(idx, dir) {
      if (idx < 0 || idx >= total || idx === current) return;
      const outEl = pages[current];
      const inEl  = pages[idx];
      outEl.classList.add('cv-exit-' + dir);
      setTimeout(function () {
        outEl.style.display = 'none';
        outEl.classList.remove('cv-exit-' + dir);
        inEl.style.display  = 'block';
        inEl.classList.add('cv-enter-' + dir);
        setTimeout(function () { inEl.classList.remove('cv-enter-' + dir); }, 450);
      }, 280);
      current = idx;
      if (currEl)  currEl.textContent  = current + 1;
      if (prevBtn) prevBtn.disabled    = current === 0;
      if (nextBtn) nextBtn.disabled    = current === total - 1;
    }

    if (prevBtn) prevBtn.addEventListener('click', function () { goTo(current - 1, 'right'); });
    if (nextBtn) nextBtn.addEventListener('click', function () { goTo(current + 1, 'left');  });

    // Click stage halves to navigate (RTL: right half = prev, left half = next)
    const stage = reader.querySelector('.cv-stage');
    if (stage) {
      stage.addEventListener('click', function (e) {
        const rect = stage.getBoundingClientRect();
        if (e.clientX > rect.left + rect.width * 0.6) goTo(current - 1, 'right');
        else if (e.clientX < rect.left + rect.width * 0.4) goTo(current + 1, 'left');
      });
    }

    // Keyboard (arrow keys)
    document.addEventListener('keydown', function (e) {
      if (!document.getElementById('comic-reader')) return;
      if (e.key === 'ArrowRight') { goTo(current - 1, 'right'); e.preventDefault(); }
      if (e.key === 'ArrowLeft')  { goTo(current + 1, 'left');  e.preventDefault(); }
    });

    // Fullscreen
    if (fsBtn) {
      fsBtn.addEventListener('click', function () {
        if (!document.fullscreenElement) {
          reader.requestFullscreen && reader.requestFullscreen();
        } else {
          document.exitFullscreen && document.exitFullscreen();
        }
      });
      document.addEventListener('fullscreenchange', function () {
        if (fsBtn) fsBtn.textContent = document.fullscreenElement ? '⊠ צא ממסך מלא' : '⛶ מסך מלא';
      });
    }

    if (prevBtn) prevBtn.disabled = true; // first page
  })();

})();
