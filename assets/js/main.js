// ============================================================
// ZHIDI Tech — Main JavaScript (v3.0)
// Light, performant, no dependencies.
// ============================================================

document.addEventListener('DOMContentLoaded', () => {
  initNavbar();
  initMobileMenu();
  initScrollAnimations();
  initFAQ();
  initTrustBarCounter();
  initGallery();
});

// ── Navbar scroll effect ──────────────────────────────────
function initNavbar() {
  const navbar = document.querySelector('.navbar');
  if (!navbar) return;

  let lastScroll = 0;
  const scrollHandler = () => {
    const scrollY = window.scrollY;
    navbar.classList.toggle('scrolled', scrollY > 10);
    lastScroll = scrollY;
  };

  window.addEventListener('scroll', scrollHandler, { passive: true });
  // Initial check
  scrollHandler();
}

// ── Mobile menu toggle ────────────────────────────────────
function initMobileMenu() {
  const toggle = document.querySelector('.menu-toggle');
  const links = document.querySelector('.navbar-links');
  if (!toggle || !links) return;

  toggle.addEventListener('click', () => {
    const isOpen = links.classList.contains('open');
    toggle.classList.toggle('active');
    links.classList.toggle('open');
    document.body.style.overflow = isOpen ? '' : 'hidden';
  });

  // Close on link click
  links.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      toggle.classList.remove('active');
      links.classList.remove('open');
      document.body.style.overflow = '';
    });
  });

  // Close on outside click
  document.addEventListener('click', (e) => {
    if (!links.classList.contains('open')) return;
    if (!toggle.contains(e.target) && !links.contains(e.target)) {
      toggle.classList.remove('active');
      links.classList.remove('open');
      document.body.style.overflow = '';
    }
  });
}

// ── Scroll-triggered animations (Intersection Observer) ──
function initScrollAnimations() {
  const elements = document.querySelectorAll('.anim-fade-up, .anim-fade-in');
  if (!elements.length) return;

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, {
    threshold: 0.1,
    rootMargin: '0px 0px -40px 0px'
  });

  elements.forEach(el => observer.observe(el));
}

// ── FAQ accordion ─────────────────────────────────────────
function initFAQ() {
  const faqItems = document.querySelectorAll('.faq-item');
  faqItems.forEach(item => {
    const question = item.querySelector('.faq-question');
    if (!question) return;

    question.addEventListener('click', () => {
      const isOpen = item.classList.contains('open');
      // Close all others (optional: accordion behavior)
      faqItems.forEach(i => i.classList.remove('open'));
      // Toggle current
      if (!isOpen) item.classList.add('open');
    });
  });
}

// ── Trust bar count-up animation ──────────────────────────
function initTrustBarCounter() {
  const numbers = document.querySelectorAll('.trust-item-number');
  if (!numbers.length) return;

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const el = entry.target;
        const text = el.textContent.trim();
        const match = text.match(/([\d,.]+)(\+?)/);
        if (!match) return;

        const target = parseFloat(match[1].replace(/,/g, ''));
        const suffix = match[2] || '';
        const prefix = text.startsWith('<') ? '<' : '';
        const duration = 1500;
        const start = performance.now();

        const update = (now) => {
          const elapsed = now - start;
          const progress = Math.min(elapsed / duration, 1);
          // Ease out cubic
          const eased = 1 - Math.pow(1 - progress, 3);
          const current = Math.round(target * eased);

          el.textContent = prefix + current.toLocaleString() + suffix;

          if (progress < 1) {
            requestAnimationFrame(update);
          }
        };

        requestAnimationFrame(update);
        observer.unobserve(el);
      }
    });
  }, { threshold: 0.5 });

  numbers.forEach(el => observer.observe(el));
}

// ── Image gallery (product detail & core showcase) ────────
function initGallery() {
  // Core showcase on homepage
  const thumbs = document.querySelectorAll('.core-showcase-thumbs img');
  const mainImg = document.getElementById('showcaseMain');
  if (thumbs.length && mainImg) {
    thumbs.forEach(thumb => {
      thumb.addEventListener('click', () => {
        mainImg.src = thumb.src;
        thumbs.forEach(t => t.classList.remove('active'));
        thumb.classList.add('active');
      });
    });
  }

  // Product detail gallery
  const galleryThumbs = document.querySelectorAll('.product-gallery-thumbs img');
  const galleryMain = document.getElementById('galleryMain');
  if (galleryThumbs.length && galleryMain) {
    galleryThumbs.forEach(thumb => {
      thumb.addEventListener('click', () => {
        galleryMain.src = thumb.src;
        galleryThumbs.forEach(t => t.classList.remove('active'));
        thumb.classList.add('active');
      });
    });
  }
}
