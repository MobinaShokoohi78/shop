/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./index.html",
        "./src/**/*.{vue,js,ts,jsx,tsx}",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js"
    ],
    theme: {
        theme: {
            fontFamily: {
                'display': ['Oswald'],
                'body': ['"Open Sans"'],
            }
        }
    },
    plugins: [
        require('flowbite/plugin')
    ],
}
