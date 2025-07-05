import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
  plugins: [
    laravel({
      input: [
        'resources/css/app.css', // File CSS utama
        'resources/js/app.js',  // File JS utama
      ],
      refresh: true, // Aktifkan auto-refresh saat development
    }),
  ],
});
