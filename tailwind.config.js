/** @type {import('tailwindcss').Config} */

const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
  content: [
    './private/app/Views/**/*.{html,twig}'
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ["'IBM Plex Sans'", ...defaultTheme.fontFamily.sans],
        mono: ["'IBM Plex Mono'", ...defaultTheme.fontFamily.mono]
      }
    },
  },
  plugins: [
    require('@tailwindcss/forms')
  ],
}
