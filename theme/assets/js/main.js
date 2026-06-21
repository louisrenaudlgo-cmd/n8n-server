// OCA Theme – main.js

(function () {
  'use strict';

  // Mobile menu toggle
  const toggle = document.querySelector('.menu-toggle');
  const nav    = document.getElementById('site-navigation');

  if (toggle && nav) {
    toggle.addEventListener('click', () => {
      const expanded = toggle.getAttribute('aria-expanded') === 'true';
      toggle.setAttribute('aria-expanded', String(!expanded));
      nav.classList.toggle('toggled');
    });
  }

  // Close mobile menu on outside click
  document.addEventListener('click', (e) => {
    if (nav && nav.classList.contains('toggled') && !nav.contains(e.target) && e.target !== toggle) {
      nav.classList.remove('toggled');
      if (toggle) toggle.setAttribute('aria-expanded', 'false');
    }
  });

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener('click', (e) => {
      const target = document.querySelector(anchor.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });
})();
