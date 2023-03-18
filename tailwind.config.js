/** @type {import('tailwindcss').Config} */

const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
  content: ['./templates/**/*.{html,twig}'],
  theme: {
    extend: {
      fontFamily: {
        sans: ["'IBM Plex Sans'", ...defaultTheme.fontFamily.sans],
        mono: ["'IBM Plex Mono'", ...defaultTheme.fontFamily.mono],
      },
      gridTemplateColumns: {
        '16': 'repeat(16, minmax(0, 1fr))'
      },
      backgroundImage: {
        'security': 'url("/assets/security-bg.jpg")'
      }
    }
  },
  plugins: [
    require('@tailwindcss/forms')
  ],
}
