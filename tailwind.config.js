module.exports = {
  content: [
    './theme/**/*.{twig,html}',
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/typography'),
  ],
}
