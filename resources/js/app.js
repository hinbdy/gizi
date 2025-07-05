require('./bootstrap');


document.addEventListener('DOMContentLoaded', function () {
  // ===============================
  // Dropdown menu (Navbar)
  // ===============================
  const dropdownButtons = document.querySelectorAll('.menu-button');
  const dropdownMenus = document.querySelectorAll('.dropdown-menu');

  dropdownButtons.forEach((btn, index) => {
    const menu = dropdownMenus[index];

    if (btn && menu) {
      // Toggle on click
      btn.addEventListener('click', (e) => {
        const isLinkClick = e.target.closest('a');

        if (!isLinkClick) {
          e.preventDefault();
          e.stopPropagation();

          // Hide all dropdowns first
          dropdownMenus.forEach((m) => {
            if (m !== menu) {
              m.classList.add('hidden');
              m.classList.add('opacity-0');
              m.classList.add('translate-y-2');
            }
          });

          // Toggle the clicked one
          menu.classList.toggle('hidden');
          menu.classList.toggle('opacity-0');
          menu.classList.toggle('translate-y-2');
        }
      });

      // Close when clicking outside
      document.addEventListener('click', (e) => {
        if (!btn.contains(e.target) && !menu.contains(e.target)) {
          menu.classList.add('hidden');
          menu.classList.add('opacity-0');
          menu.classList.add('translate-y-2');
        }
      });

      // Close with Esc
      document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
          menu.classList.add('hidden');
          menu.classList.add('opacity-0');
          menu.classList.add('translate-y-2');
        }
      });
    }
  });

  // ===============================
  // Search input reset button
  // ===============================
  const searchInput = document.getElementById('searchInput');
  const resetButton = document.getElementById('resetButton');

  if (searchInput && resetButton) {
    searchInput.addEventListener('input', function () {
      if (this.value.trim() !== '') {
        resetButton.classList.remove('hidden');
      } else {
        resetButton.classList.add('hidden');
      }
    });

    resetButton.addEventListener('click', function () {
      searchInput.value = '';
      resetButton.classList.add('hidden');
    });
  }

  // ===============================
  // Flickity carousel
  // ===============================
  const carousel = document.querySelector('.testi-carousel');
  if (carousel) {
    const flkty = new Flickity(carousel, {
      cellAlign: 'left',
      contain: true,
      pageDots: false,
      prevNextButtons: false,
    });

    const prevButton = document.querySelector('.btn-prev');
    const nextButton = document.querySelector('.btn-next');

    if (prevButton) {
      prevButton.addEventListener('click', function () {
        flkty.previous(true);
      });
    }

    if (nextButton) {
      nextButton.addEventListener('click', function () {
        flkty.next(true);
      });
    }
  }

  // ===============================
  // Mobile menu toggle
  // ===============================
  const mobileToggle = document.querySelector('.mobile-menu-toggle');
  const mobileMenu = document.querySelector('.mobile-menu');

  if (mobileToggle && mobileMenu) {
    mobileToggle.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
    });
  }
});

