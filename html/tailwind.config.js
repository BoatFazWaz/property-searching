/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Raleway', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        serif: ['Playfair Display', 'ui-serif', 'Georgia', 'serif'],
      },
      colors: {
        indigo: {
          900: '#1a237e',
          800: '#283593',
        },
        purple: {
          900: '#4a148c',
          800: '#6a1b9a',
        },
        gold: {
          DEFAULT: '#D4AF37',
          light: '#F5E7A3',
          dark: '#996515',
        },
      },
      boxShadow: {
        'luxury': '0 10px 30px -5px rgba(0, 0, 0, 0.1)',
        'luxury-lg': '0 20px 40px -5px rgba(0, 0, 0, 0.15)',
      },
      backgroundImage: {
        'gradient-luxury': 'linear-gradient(to right, #1a237e, #4a148c)',
      },
    },
  },
  plugins: [
    // Line clamp is now part of core Tailwind CSS in v3.3+
  ],
} 