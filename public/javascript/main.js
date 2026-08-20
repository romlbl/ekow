window.addEventListener('scroll', () => {
  const scrollY = window.scrollY;

  const slow = document.querySelector('.mainImg');
  const fast = document.querySelector('.preview_container');
  slow.style.transform = `translateY(${scrollY * 0.1}px)`;
  fast.style.transform = `translateY(${-scrollY * 0.1}px)`;
});

document.addEventListener("DOMContentLoaded", () => {
  const sections = document.querySelectorAll('.widecontainer');

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('show');
      }
    });
  }, {
    threshold: 0.3
  });

  sections.forEach(section => observer.observe(section));
});