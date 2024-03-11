/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./views/.{php}",
    "./views/*.{php}",
    "./src/components/*.{php}",
    "./src/components/*.{php}",
    "./src/components/**/*.{php}",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
};
