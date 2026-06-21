/* OCA Theme v2 – main.js */
(function () {
  'use strict';

  // ── Mobile menu ─────────────────────────────────────────────────────────────
  const toggle = document.querySelector('.menu-toggle');
  const nav    = document.querySelector('.primary-nav');

  if (toggle && nav) {
    toggle.addEventListener('click', () => {
      const open = nav.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', String(open));
      document.body.style.overflow = open ? 'hidden' : '';
    });

    // Close on outside click
    document.addEventListener('click', (e) => {
      if (nav.classList.contains('is-open') && !nav.contains(e.target) && e.target !== toggle) {
        nav.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
      }
    });

    // Close on Escape
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && nav.classList.contains('is-open')) {
        nav.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
      }
    });
  }

  // ── Dropdown ARIA on mobile ──────────────────────────────────────────────────
  document.querySelectorAll('.menu-item-has-children > a').forEach((link) => {
    link.addEventListener('click', (e) => {
      if (window.innerWidth <= 768) {
        e.preventDefault();
        const parent  = link.parentElement;
        const submenu = parent.querySelector('.sub-menu');
        const open    = parent.classList.toggle('sub-open');
        if (submenu) submenu.style.display = open ? 'block' : '';
        link.setAttribute('aria-expanded', String(open));
      }
    });
  });

  // ── Smooth scroll ───────────────────────────────────────────────────────────
  document.querySelectorAll('a[href^="#"]').forEach((a) => {
    a.addEventListener('click', (e) => {
      const target = document.querySelector(a.getAttribute('href'));
      if (target) {
        e.preventDefault();
        const offset = 80; // header height
        const top    = target.getBoundingClientRect().top + window.scrollY - offset;
        window.scrollTo({ top, behavior: 'smooth' });
      }
    });
  });

  // ── KPI counter animation ───────────────────────────────────────────────────
  function animateCounter(el) {
    const target = parseInt(el.textContent.replace(/\D/g, ''), 10);
    if (isNaN(target) || target === 0) return;
    const duration = 1200;
    const start    = performance.now();
    const from     = Math.max(0, target - Math.round(target * 0.3));

    function step(now) {
      const progress = Math.min((now - start) / duration, 1);
      const ease     = 1 - Math.pow(1 - progress, 3);
      el.textContent = Math.round(from + (target - from) * ease);
      if (progress < 1) requestAnimationFrame(step);
      else el.textContent = target;
    }
    requestAnimationFrame(step);
  }

  const kpiEls = document.querySelectorAll('.kpi-value, .kpi-band-number');
  if ('IntersectionObserver' in window) {
    const obs = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          animateCounter(entry.target);
          obs.unobserve(entry.target);
        }
      });
    }, { threshold: 0.5 });
    kpiEls.forEach((el) => obs.observe(el));
  }

  // ── Active nav link ─────────────────────────────────────────────────────────
  const currentPath = window.location.pathname;
  document.querySelectorAll('.primary-nav a').forEach((a) => {
    try {
      const linkPath = new URL(a.href).pathname;
      if (linkPath !== '/' && currentPath.startsWith(linkPath)) {
        a.closest('li')?.classList.add('current-menu-item');
      }
    } catch (_) {}
  });

  // ── Alert ticker close ──────────────────────────────────────────────────────
  const ticker = document.querySelector('.alert-ticker');
  if (ticker) {
    ticker.addEventListener('dblclick', () => {
      ticker.style.display = 'none';
    });
  }

})();
