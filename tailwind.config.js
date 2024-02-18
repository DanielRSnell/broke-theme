module.exports = {
  content: [
    './theme/views/**/*.twig',
    './theme/layouts/**/*.twig',
    './theme/helpers/**/*.twig',
    './theme/blocks/**/*.twig',
    './theme/views/components/**/*.twig',
  ],
  theme: {
    extend: {},
  },
  plugins: [
    require('@tailwindcss/typography'),
  ],
}
