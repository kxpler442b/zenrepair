/** @type {import('tailwindcss').Config} */

const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
  content: ['./templates/**/*.{html,twig}'],
  theme: {
    extend: {
      fontFamily: {
        sans: ["'Space Grotesk'", ...defaultTheme.fontFamily.sans],
        mono: ["'Space Mono'", ...defaultTheme.fontFamily.mono]
      },
      gridTemplateRows: {
        'layout': '64px repeat(4, minmax(0, 1fr))'
      },
      gridTemplateColumns: {
        'layout': 'repeat(12, minmax(0, 1fr))',
        'layout_2xl': '300px repeat(10, minmax(0, 1fr))'
      },
    }
  },
  plugins: [
    require('@tailwindcss/forms')
  ],
}
