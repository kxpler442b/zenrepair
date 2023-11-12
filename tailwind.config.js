/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme')

module.exports = {
  content: ['./templates/**/*.twig'],
  theme: {
    extend: {
      fontFamily: {
        sans: ["Satoshi-Variable", ...defaultTheme.fontFamily.sans],
      },
      gridTemplateRows: {
        'custom-1': '48px'
      },
      gridTemplateColumns: {
        'xl': 'repeat(12, minmax(0, 1fr))',
        '2xl': 'repeat(16, minmax(0, 1fr))'
      },
      gridColumns: {
        'span-16': 'span 16 / span 16',
        'span-17': 'span 17 / span 17',
      },
      gridColumnEnd: {
        '8': '8',
        '9': '9',
        '10': '10',
        '11': '11',
        '12': '12',
        '13': '13',
        '14': '14',
        '15': '15',
        '16': '16',
        '17': '17',
      }
    },
  },
  plugins: [
    require('@tailwindcss/forms')
  ],
}