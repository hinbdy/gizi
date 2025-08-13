// =====================
// Import dependencies
// =====================
import './bootstrap';

// Third-party libraries
import Flickity from 'flickity';
import 'flickity/css/flickity.css';
import TomSelect from 'tom-select';
window.TomSelect = TomSelect;

// Alpine.js + Plugins
import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';
import intersect from '@alpinejs/intersect';

// Livewire global access
window.Alpine = Alpine;

// =====================
// Alpine & Livewire Setup
// =====================

// Pasang plugin Alpine saat event 'alpine:init' dari Livewire
document.addEventListener('alpine:init', () => {
    Alpine.plugin(persist);
    Alpine.plugin(intersect);
    console.log("Alpine plugins loaded into Livewire's Alpine instance.");
});

// Mulai Livewire (akan otomatis memulai Alpine milik Livewire)
Livewire.start();

// =====================
// Plugin Initialization
// =====================
function initializePlugins() {
    console.log("Plugins re-initialized by Livewire hook.");

    // Flickity carousel
    const carousel = document.querySelector('.testi-carousel');
    if (carousel) {
        let flkty = Flickity.data(carousel);
        if (flkty) flkty.destroy();

        new Flickity(carousel, {
            cellAlign: 'left',
            contain: true,
            pageDots: false,
            prevNextButtons: false,
        });
    }

    // Mobile menu toggle
    const mobileToggle = document.querySelector('.mobile-menu-toggle');
    const mobileMenu = document.querySelector('.mobile-menu');

    if (mobileToggle && mobileMenu && !mobileToggle.dataset.listenerAttached) {
        mobileToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
        mobileToggle.dataset.listenerAttached = 'true';
    }
}

// =====================
// Livewire Hooks
// =====================
document.addEventListener('livewire:init', () => {
    Livewire.hook('element.init', () => {
        initializePlugins();
    });
});
