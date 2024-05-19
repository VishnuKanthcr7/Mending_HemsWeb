/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['*.php'],
  theme: {
    extend: {
      fontFamily: {
        raleway: "'Raleway', sans-serif",
        roboto: "'Roboto', sans-serif",
      },
      screens: {
        fl: {
          raw: '(min-height:700px)',
        },
      },
    },
  },
  plugins: [require('@tailwindcss/typography')],
}
