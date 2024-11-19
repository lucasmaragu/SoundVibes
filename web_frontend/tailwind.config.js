/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./src/**/*.{js,jsx,ts,tsx}"
  ],
  theme: {
    extend: {
      colors: {
        'gris-spotify': '#1F1F1F',
        'gris-spotify-oscuro': '#121212',
        'gris-texto': '#B3B3B3',
        'gris-boton': '#333333'
      },
    }
  },
  plugins: [],
}

