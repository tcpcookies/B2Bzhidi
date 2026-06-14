// ===== ZHIDI Tech — Main JavaScript (v2.0) =====

document.addEventListener('DOMContentLoaded', () => {
  initNavbar();
  initMobileMenu();
  initScrollAnimations();
  initFAQ();
  initTrustBarCounter();
});

// Navbar scroll effect — shrink on scroll
function initNavbar() {
  const navbar = document.querySelector('.navbar');
  if (!navbar) return;

  let lastScroll = 0;
  window.addEventListener('scroll', () => {
    const scrollY = window.scrollY;
    navbar.classList.toggle('scrolled', scrollY > 10);
    lastScroll = scrollY;
  }, { passive: true });
}

// Mobile menu toggle
function initMobileMenu() {
  const toggle = document.querySelector('.menu-toggle');
  const links = document.querySelector('.navbar-links');
  if (!toggle || !links) return;

  toggle.addEventListener('click', () => {
    toggle.classList.toggle('active');
    links.classList.toggle('open');
  });

  // Close on link click
  links.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      toggle.classList.remove('active');
      links.classList.remove('open');
    });
  });
}

// Scroll animations — fade-in, slide-up, slide-left
function initScrollAnimations() {
  const elements = document.querySelectorAll('.fade-in, .slide-up, .slide-left');
  if (!elements.length) return;

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -60px 0px' });

  elements.forEach(el => observer.observe(el));
}

// Trust bar number counter animation
function initTrustBarCounter() {
  const numbers = document.querySelectorAll('.trust-item-number');
  if (!numbers.length) return;

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const el = entry.target;
        const text = el.textContent.trim();
        // Extract number and suffix (e.g. "73+" → 73, "+")
        const match = text.match(/(\d+)(.*)/);
        if (match) {
          const target = parseInt(match[1], 10);
          const suffix = match[2] || '';
          animateCounter(el, target, suffix);
        }
        observer.unobserve(el);
      }
    });
  }, { threshold: 0.5 });

  numbers.forEach(el => observer.observe(el));
}

function animateCounter(el, target, suffix, duration = 1500) {
  const start = 0;
  const startTime = performance.now();

  function update(currentTime) {
    const elapsed = currentTime - startTime;
    const progress = Math.min(elapsed / duration, 1);
    // Ease-out cubic
    const eased = 1 - Math.pow(1 - progress, 3);
    const current = Math.round(start + (target - start) * eased);
    el.textContent = current + suffix;

    if (progress < 1) {
      requestAnimationFrame(update);
    }
  }

  requestAnimationFrame(update);
}

// FAQ accordion
function initFAQ() {
  const items = document.querySelectorAll('.faq-item');
  if (!items.length) return;

  items.forEach(item => {
    const question = item.querySelector('.faq-question');
    question.addEventListener('click', () => {
      const isOpen = item.classList.contains('open');
      // Close all
      items.forEach(i => i.classList.remove('open'));
      // Toggle current
      if (!isOpen) item.classList.add('open');
    });
  });
}

// Form submission handler
function handleFormSubmit(formId, successMsg) {
  const form = document.getElementById(formId);
  if (!form) return;

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    const btn = form.querySelector('button[type="submit"]');
    const originalText = btn.innerHTML;
    btn.innerHTML = '<span>Sending...</span>';
    btn.disabled = true;

    try {
      const response = await fetch(form.action, {
        method: 'POST',
        body: new FormData(form),
        headers: { 'Accept': 'application/json' }
      });

      if (response.ok) {
        form.reset();
        // Show success message inline
        const successDiv = document.createElement('div');
        successDiv.style.cssText = 'background:#10b981;color:#fff;padding:16px 24px;border-radius:10px;margin-top:16px;font-weight:600;text-align:center;';
        successDiv.textContent = successMsg || 'Thank you! We will contact you shortly.';
        form.parentNode.insertBefore(successDiv, form.nextSibling);
        setTimeout(() => successDiv.remove(), 5000);
      } else {
        throw new Error('Form submission failed');
      }
    } catch (err) {
      alert('Something went wrong. Please try again or contact us directly.');
    } finally {
      btn.innerHTML = originalText;
      btn.disabled = false;
    }
  });
}
