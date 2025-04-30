/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./*.html"],
  theme: {
    extend: {
      fontFamily: {
        'abeezee': ['ABeeZee', 'sans-serif'], // Если у тебя уже был этот шрифт
        'bakbak-one': ['Bakbak One', 'cursive'], // Добавляем шрифт Bakbak One
      },
    },
  },
  plugins: [],
}