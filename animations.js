// Premium Animation System - European Design Studio

class AnimationController {
  constructor() {
    this.init();
  }

  init() {
    this.setupIntersectionObserver();
    this.setupNavbar();
    this.setupMobileMenu();
    this.setupHeroAnimations();
    this.setupParallax();
  }

  // Intersection Observer for Scroll Reveals
  setupIntersectionObserver() {
    const options = {
      threshold: 0.15,
      rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('visible');
        }
      });
    }, options);

    // Observe all animated elements
    const animatedElements = document.querySelectorAll(
      '.fade-up, .fade-left, .fade-right, .scale-in, .fade-in, ' +
      '.service-card, .creative-image, .creative-text, ' +
      '.process-card, .process-number, .process-line, ' +
      '.testimonial-card, .cta-text, .footer-content, ' +
      '.hero-text-stagger, .hero-image'
    );

    animatedElements.forEach(el => observer.observe(el));
  }

  // Navbar Scroll Effect
  setupNavbar() {
    const navbar = document.getElementById('navbar');
    let lastScroll = 0;

    window.addEventListener('scroll', () => {
      const currentScroll = window.pageYOffset;

      if (currentScroll > 100) {
        navbar.classList.add('scrolled');
      } else {
        navbar.classList.remove('scrolled');
      }

      lastScroll = currentScroll;
    });
  }

  // Mobile Menu Animation
  setupMobileMenu() {
    const hamburger = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobileMenu');

    if (hamburger && mobileMenu) {
      hamburger.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
        setTimeout(() => {
          mobileMenu.classList.toggle('active');
        }, 10);
      });
    }
  }

  // Hero Section Animations
  setupHeroAnimations() {
    // Stagger text animations
    const heroElements = document.querySelectorAll('.hero-text-stagger');
    heroElements.forEach((el, index) => {
      setTimeout(() => {
        el.classList.add('visible');
      }, 400 + (index * 150));
    });

    // Button hover effects
    const buttons = document.querySelectorAll('.hero-button, .cta-button');
    buttons.forEach(button => {
      button.addEventListener('mouseenter', (e) => {
        const rect = button.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        
        const ripple = document.createElement('span');
        ripple.style.cssText = `
          position: absolute;
          left: ${x}px;
          top: ${y}px;
          width: 0;
          height: 0;
          border-radius: 50%;
          background: rgba(255, 255, 255, 0.3);
          transform: translate(-50%, -50%);
          pointer-events: none;
        `;
        
        button.style.position = 'relative';
        button.style.overflow = 'hidden';
        button.appendChild(ripple);
        
        setTimeout(() => ripple.remove(), 600);
      });
    });
  }

  // Subtle Parallax Effect
  setupParallax() {
    const parallaxElements = document.querySelectorAll('.parallax');
    
    if (parallaxElements.length === 0) return;

    window.addEventListener('scroll', () => {
      const scrolled = window.pageYOffset;
      
      parallaxElements.forEach(el => {
        const speed = el.dataset.speed || 0.5;
        const yPos = -(scrolled * speed);
        el.style.transform = `translateY(${yPos}px)`;
      });
    });
  }
}

// Initialize on DOM ready
if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', () => {
    new AnimationController();
  });
} else {
  new AnimationController();
}
