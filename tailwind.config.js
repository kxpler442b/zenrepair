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
        'layout': '48px 64px 48px repeat(8, minmax(0, 1fr))',
        'layout_2xl': '48px 64px 48px repeat(2, minmax(0, 1fr))'
      },
      gridTemplateColumns: {
        'layout': 'repeat(16, minmax(0, 1fr))',
        'layout_2xl': '300px repeat(10, minmax(0, 1fr))'
      },
    }
  },
  plugins: [
    require('@tailwindcss/forms')
  ],
}
