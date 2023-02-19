/** @type {import('tailwindcss').Config} */

const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');

module.exports = {
  content: ['./resources/views/**/*.{html,twig}'],
  theme: {
    extend: {
      fontFamily: {
        sans: ["'Overpass'", ...defaultTheme.fontFamily.sans],
        mono: ["'DM Mono'", ...defaultTheme.fontFamily.mono]
      },
    }
  },
  plugins: [
    require('@tailwindcss/forms')
  ],
}
