/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    './*.php', // Si tienes archivos PHP en la carpeta 'views'
    './**/*.php', // Si tienes archivos PHP en la carpeta 'views'
    './public/**/*.html', // Si tienes archivos HTML en la carpeta 'public'
    './styles/**/*.css' // Si también usas clases dentro de archivos CSS
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}
