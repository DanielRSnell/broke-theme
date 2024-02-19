const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');
const { scrollbarGutter, scrollbarWidth, scrollbarColor } = require('tailwind-scrollbar-utilities');

module.exports = {
  content: [
    './theme/views/**/*.twig',
    './theme/layouts/components/**/*.{twig,html}',
    './theme/helpers/**/*.html',
    './theme/blocks/**/*.twig',
    './theme/views/components/**/*.twig',
  ],
  theme: {
    extend: {
      fontSize: {
        xs: ['0.75rem', { lineHeight: '1rem' }],
        sm: ['0.875rem', { lineHeight: '1.5rem' }],
        base: ['1rem', { lineHeight: '1.75rem' }],
        lg: ['1.125rem', { lineHeight: '1.75rem' }],
        xl: ['1.25rem', { lineHeight: '2rem' }],
        '2xl': ['1.5rem', { lineHeight: '2.25rem' }],
        '3xl': ['1.75rem', { lineHeight: '2.25rem' }],
        '4xl': ['2rem', { lineHeight: '2.5rem' }],
        '5xl': ['2.5rem', { lineHeight: '3rem' }],
        '6xl': ['3rem', { lineHeight: '3.5rem' }],
        '7xl': ['4rem', { lineHeight: '4.5rem' }],
      },
      colors: {
        primary: colors.slate,
        accent: colors.blue,
        secondary: colors.green,
        pop: colors.indigo,
        link: colors.sky,
        base: {
          ...colors.gray,
          darkest: colors.black,
          dark: colors.gray[800],
          DEFAULT: colors.gray[700],
          light: colors.gray[300],
          lightest: colors.gray[100],
        },
        neutral: colors.neutral,
        canvas: colors.slate,
        transparent: 'transparent',
      },
      borderRadius: {
        '4xl': '2rem',
        '5xl': '3rem',
        '6xl': '5rem',
      },
      fontFamily: {
        sans: ['Inter', ...defaultTheme.fontFamily.sans],
        display: ['Inter', ...defaultTheme.fontFamily.sans],
      },
    },
  },
  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
    require('tailwind-scrollbar-hide'),
    scrollbarGutter(),
    scrollbarWidth(),
    scrollbarColor(),
  ],
}
