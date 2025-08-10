// 1. Ganti `require` dengan `import` yang sesuai untuk Vite
import './bootstrap';

// 2. Import semua library yang kita butuhkan
import Flickity from 'flickity';
import 'flickity/css/flickity.css'; // Import juga CSS-nya
import Alpine from 'alpinejs';
import persist from '@alpinejs/persist'; 
import intersect from '@alpinejs/intersect';
import TomSelect from 'tom-select';
window.TomSelect = TomSelect; 

Alpine.plugin(persist);
window.Alpine = Alpine;
Alpine.start();
Alpine.plugin(intersect); 
// 3. Kita bungkus semua logika inisialisasi Anda ke dalam satu fungsi
function initializePlugins() {

    console.log('Plugins initialized'); // Pesan ini akan muncul di console browser, untuk debugging

    // ==========================================================
    // --- SEMUA KODE ANDA YANG PENTING DIMASUKKAN DI SINI ---
    // ==========================================================

    // Dropdown menu (Navbar)
    const dropdownButtons = document.querySelectorAll('.menu-button');
    const dropdownMenus = document.querySelectorAll('.dropdown-menu');
    dropdownButtons.forEach((btn, index) => {
        const menu = dropdownMenus[index];
        if (btn && menu) {
            // ... (logika dropdown Anda, tidak diubah)
        }
    });

    // Search input reset button
    const searchInput = document.getElementById('searchInput');
    const resetButton = document.getElementById('resetButton');
    if (searchInput && resetButton) {
        // ... (logika search reset Anda, tidak diubah)
    }

    // Flickity carousel
    const carousel = document.querySelector('.testi-carousel');
    if (carousel) {
        // Cek jika flickity sudah ada, hancurkan dulu sebelum membuat yang baru
        // Ini mencegah error "bad cell" pada update Livewire
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


// ===================================================================
// --- INI ADALAH KUNCI UTAMA PERBAIKANNYA ---
// ===================================================================

// 4. Jalankan fungsi di atas saat halaman pertama kali dimuat
document.addEventListener('DOMContentLoaded', () => {
    initializePlugins();
});

// 5. Jalankan KEMBALI fungsi di atas SETIAP KALI Livewire selesai memperbarui halaman
document.addEventListener('livewire:navigated', () => {
    initializePlugins();
});