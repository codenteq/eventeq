/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',
    content: [
        './node_modules/@codenteq/**/*.{js,ts,jsx,tsx}',
        "./resources/**/*.js",
        "./resources/**/*.jsx",
    ],
  theme: {
    extend: {
        colors: {
            transparent: 'transparent',
            current: 'currentColor',
            white: '#ffffff',
            black: '#000000',
            brand: '#003366',
        },
    },
  },
  plugins: [require('@tailwindcss/forms')],
}

