const observerOptions = {
  root: null,
  rootMargin: '0px 0px -50px 0px',
  threshold: 0.1,
};

const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      entry.target.classList.add('reveal-active');
      observer.unobserve(entry.target);
    }
  });
}, observerOptions);

export const vReveal = {
  mounted(el, binding) {
    // Default base class if not already added
    if (!el.classList.contains('reveal') && 
        !el.classList.contains('reveal-down') && 
        !el.classList.contains('reveal-scale') && 
        !el.classList.contains('reveal-left') && 
        !el.classList.contains('reveal-right')) {
      el.classList.add('reveal');
    }

    // Optional delay passed via modifier or arg (e.g., v-reveal.delay-200 or v-reveal="200")
    if (typeof binding.value === 'number') {
      el.style.transitionDelay = `${binding.value}ms`;
    }

    observer.observe(el);
  },
  unmounted(el) {
    observer.unobserve(el);
  },
};
