/** @type {import('tailwindcss').Config} */

const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
  content: ['./resources/views/**/*.{html,twig}'],
  theme: {
    extend: {
      fontFamily: {
        sans: ["'Space Grotesk'", ...defaultTheme.fontFamily.sans],
        mono: ["'Space Mono'", ...defaultTheme.fontFamily.mono],
        phosphor: ["'Phosphor'"]
      },
    }
  },
  plugins: [
    require('@tailwindcss/forms')
  ],
}
