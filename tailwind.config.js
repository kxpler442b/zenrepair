/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme');
module.exports = {
  content: ['./templates/**/*.{html,twig}'],
  theme: {
    extend: {
      fontFamily: {
        sans: ["Satoshi-Variable", ...defaultTheme.fontFamily.sans],
      },
      boxShadow: {
        'brutal': '0.2rem 0.2rem 0 0px #000;'
      }
    },
  },
  plugins: [
    require('@tailwindcss/forms')
  ],
}