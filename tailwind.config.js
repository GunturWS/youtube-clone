/** @type {import('tailwindcss').Config} */

const defaultTheme = require("tailwindcss/defaultTheme");

export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./index.html",
        "./src/**/*.{vue,js}",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['"Inter"', ...defaultTheme.fontFamily.sans],
                mono: ['"JetBrains Mono"', ...defaultTheme.fontFamily.mono],
            },
            colors: {
                "nova-dark": "#242424",
                "nova-gray": "#665c54",
                "nova-milk": "#e7d7ad",
                "nova-red": "#fb4934",
                "nova-green": "#98971a",
                "nova-yellow": "#fabd2f",
            },
        },
    },

    plugins: [],
};
