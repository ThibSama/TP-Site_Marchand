/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./front/*.php", "./js/*.js"],
  theme: {
    extend: {
      colors: {
        glaucousBlue: {
          DEFAULT: '#507DBC',
          dark: '#315a8c',  // Ajustez ces valeurs selon votre préférence pour le mode sombre
        },
        spaceBlack: {
          DEFAULT: '#1D1818',
          dark: '#101010',  // Ajustez ces valeurs selon votre préférence pour le mode sombre
        },
        lavenderWhite: {
          DEFAULT: '#E0E0E0',
          dark: '#a8a8a8',  // Ajustez ces valeurs selon votre préférence pour le mode sombre
        }
      }
    }
  },
  darkMode: 'class',
  plugins: [],
}