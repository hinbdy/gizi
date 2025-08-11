import './bootstrap';

// Import semua library
import Flickity from 'flickity';
import 'flickity/css/flickity.css';
import TomSelect from 'tom-select';
window.TomSelect = TomSelect;

// Import Livewire untuk menggunakan hooks
import { Livewire } from '../../vendor/livewire/livewire/dist/livewire.esm';

import Alpine from 'alpinejs';
import persist from '@alpinejs/persist';
import intersect from '@alpinejs/intersect';

// 1. Daftarkan SEMUA plugin terlebih dahulu
Alpine.plugin(persist);
Alpine.plugin(intersect);

// 2. Jadikan Alpine global
window.Alpine = Alpine;

// 3. Baru jalankan Alpine
// Alpine.start();
Livewire.start();

document.addEventListener('alpine:init', () => {
    // Setelah Alpine dari Livewire siap, tambahkan plugin ke dalamnya
    window.Alpine.plugin(persist);
    window.Alpine.plugin(intersect);
    console.log('Alpine plugins loaded into Livewire\'s Alpine instance.');
});


// Fungsi untuk menginisialisasi plugin JavaScript Anda
function initializePlugins() {
    console.log('Plugins re-initialized by Livewire hook.'); // Untuk debugging

    // Logika Dropdown, Search, dll. Anda letakkan di sini...
    // Contoh: Flickity carousel
    const carousel = document.querySelector('.testi-carousel');
    if (carousel) {
        let flkty = Flickity.data(carousel);
        if (flkty) {
            flkty.destroy();
        }
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
    if (mobileToggle && mobileMenu) {
        if (!mobileToggle.dataset.listenerAttached) {
            mobileToggle.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
            mobileToggle.dataset.listenerAttached = 'true';
        }
    }
}

document.addEventListener('livewire:init', () => {
    Livewire.hook('element.init', () => {
        initializePlugins();
    });
});