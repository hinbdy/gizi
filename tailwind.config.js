/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: 'class',
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./public/**/*.html",
    "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/tailwind.blade.php",
    
  ],
  theme: {
    extend: {
        screens: {
        'landscape-mobile': {'raw': '(max-width: 900px) and (orientation: landscape)'},
        },
      zIndex: {
        '-1': '-1',
        '-10': '-10',
        '-20': '-20',
      },
      colors: {
        gizila: {
          primary: '#4CAF50',
          secondary: '#8BC34A',
          accent: '#CDDC39',
          dark: '#2E7D32',
          light: '#A5D6A7',
        },
        belibang: {
          black: '#121212',
          gray: '#A0A0A0',
          lightGray: '#D0D0D0',
          darkGray: '#414141',
          darkerGray: '#1E1E1E',
        },
      },
      fontFamily: {
        poppins: ['Poppins', 'sans-serif'],
      },
      backgroundImage: {
        'gizila-radial': 'radial-gradient(circle at top left, #b1fcb5 0%, #e6ffe6 30%, #f7fff7 100%)',
        'gradient-purple-orange': 'linear-gradient(to bottom right, #B05CB0, #FCB16B)',
        'gradient-black': 'linear-gradient(to bottom right, #1E1E1E, #181818)',
        
      },
      animation: {
        fadeIn: 'fadeIn 0.3s ease-out',
        fadeOut: 'fadeOut 0.3s ease-in',
        slideToR: 'slideToR 0.5s ease-in-out',
        slideToT: 'slideToT 0.5s ease-in-out',
        slideToB: 'slideToB 0.5s ease-in-out',
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0', transform: 'scale(0.95)' },
          '100%': { opacity: '1', transform: 'scale(1)' },
        },
        fadeOut: {
          '0%': { opacity: '1', transform: 'scale(1)' },
          '100%': { opacity: '0', transform: 'scale(0.95)' },
        },
        slideToR: {
          "0%": { transform: "translateX(-100%)" },
          "100%": { transform: "translateX(0%)" },
        },
        slideToT: {
          "0%": { transform: "translateY(0%)" },
          "100%": { transform: "translateY(-100%)" },
        },
        slideToB: {
          "0%": { transform: "translateY(-100%)" },
          "100%": { transform: "translateY(0%)" },
        },
      },
    },
  },
  
  plugins: [require('@tailwindcss/typography')],
};
