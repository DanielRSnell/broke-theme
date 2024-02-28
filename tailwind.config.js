const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors');
const { scrollbarGutter, scrollbarWidth, scrollbarColor } = require('tailwind-scrollbar-utilities');
const plugin = require('tailwindcss/plugin')

module.exports = {
  content: [
    './theme/views/**/*.twig',
    './theme/helpers/**/*.html',
    './theme/blocks/**/*.twig',
    './theme/views/components/**/*.twig',
  ],
   darkMode: 'class',
  theme: {
     fontSize: {
      xs: [
        "0.75rem",
        {
          lineHeight: "1rem",
        },
      ],
      sm: [
        "0.875rem",
        {
          lineHeight: "1.5rem",
        },
      ],
      base: [
        "1rem",
        {
          lineHeight: "1.75rem",
        },
      ],
      lg: [
        "1.125rem",
        {
          lineHeight: "2rem",
        },
      ],
      xl: [
        "1.25rem",
        {
          lineHeight: "2rem",
        },
      ],
      "2xl": [
        "1.5rem",
        {
          lineHeight: "2rem",
        },
      ],
      "3xl": [
        "2rem",
        {
          lineHeight: "2.5rem",
        },
      ],
      "4xl": [
        "2.5rem",
        {
          lineHeight: "3.5rem",
        },
      ],
      "5xl": [
        "3rem",
        {
          lineHeight: "3.5rem",
        },
      ],
      "6xl": [
        "3.75rem",
        {
          lineHeight: "1",
        },
      ],
      "7xl": [
        "4.5rem",
        {
          lineHeight: "1.1",
        },
      ],
      "8xl": [
        "6rem",
        {
          lineHeight: "1",
        },
      ],
      "9xl": [
        "8rem",
        {
          lineHeight: "1",
        },
      ],
    },
    extend: {
      boxShadow: {
        thick: "0px 7px 32px rgb(0 0 0 / 35%);",
      },
      colors: {
         primary: {
          light: '#FEFCE8',
          lightest: '#FEF9C3',
          DEFAULT: '#FACC15',
          dark: '#F59E0B',
        },
          brand: {
          50: '#FEFCE8',
          100: '#FEFCE8',
          200: '#FEFCE8',
          300: '#FEF9C3',
          400: '#FEF9C3',
          500: '#FACC15',
          600: '#FACC15',
          700: '#FACC15',
          800: '#FACC15',
          900: '#F59E0B',
        },
        accent: {
          50: '#FFF9EB',
          100: '#FFF1CC',
          200: '#FFE9B0',
          300: '#FFDF8A',
          400: '#FFD873',
          500: '#FFD158',
          600: '#FFCB42',
          700: '#FFC428',
          800: '#FFBF1A',
          900: '#EFAC00',
        },
        success: {
          50: '#E5FDF4',
          100: '#C3F9E6',
          200: '#A5F4D8',
          300: '#6BECBE',
          400: '#58E1B0',
          500: '#43D29F',
          600: '#25CA8E',
          700: '#17C083',
          800: '#0BB678',
          900: '#00AD6F',
        },
        warning: {},
        error: {
          50: '#FFE5E6',
          100: '#FFC8C8',
          200: '#FFB4B4',
          300: '#FF9595',
          400: '#FF7979',
          500: '#FF6666',
          600: '#FB4949',
          700: '#F02E2E',
          800: '#E10808',
          900: '#C30000',
        },
        },
      spacing: {
        '128': '32rem',
        '144': '36rem',
      },
      borderRadius: {
        "4xl": "2rem",
        "5xl": "3rem",
        "6xl": "5rem",
      },
    },
  },
  plugins: [
        require('flowbite-typography'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/forms'),
        require('flowbite/plugin'),
        plugin(function({ addVariant }) {
            addVariant('htmx-settling', ['&.htmx-settling', '.htmx-settling &']);
            addVariant('htmx-request',  ['&.htmx-request',  '.htmx-request &']);
            addVariant('htmx-swapping', ['&.htmx-swapping', '.htmx-swapping &']);
            addVariant('htmx-added',    ['&.htmx-added',    '.htmx-added &']);
        }),
        // ... additional plugins if any ...
    ]
}
