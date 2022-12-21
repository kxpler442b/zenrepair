/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./private/app/views/**/*.{html, twig}'],
  theme: {
    extend: {
      fontFamily: {
        'inter': ['Inter', 'sans-serif']
      },
    },
  },
  plugins: [],
}
