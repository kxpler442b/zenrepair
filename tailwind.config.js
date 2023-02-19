/** @type {import('tailwindcss').Config} */

const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
  content: ['./resources/views/**/*.{html,twig}'],
  theme: {
    extend: {
      fontFamily: {
        sans: ["'Inter'", ...defaultTheme.fontFamily.sans],
        mono: ["'Space Mono'", ...defaultTheme.fontFamily.mono]
      },
    }
  },
  plugins: [
    require('@tailwindcss/forms')
  ],
}
