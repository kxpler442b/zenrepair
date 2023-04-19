/** @type {import('tailwindcss').Config} */

const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
  content: ['./templates/**/*.{html,twig}'],
  theme: {
    extend: {
      fontFamily: {
        title: ["'Space Grotesk'", ...defaultTheme.fontFamily.sans],
        sans: ["'Inter'", ...defaultTheme.fontFamily.sans],
        mono: ["'Space Mono'", ...defaultTheme.fontFamily.mono]
      },
      gridTemplateRows: {
        'layout': '48px 144px repeat(5, minmax(0, 1fr))'
      },
      gridTemplateColumns: {
        'layout': 'repeat(12, minmax(0, 1fr))',
      },
    }
  },
  plugins: [
    require('@tailwindcss/forms')
  ],
}
