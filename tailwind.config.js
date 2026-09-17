/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./application/views/**/*.php"
    ],
    theme: {
        extend: {
            colors: {

                primary: '#9F1D35',
                secondary: '#6B7280',

                success: '#22C55E',
                danger: '#DC2626',
                warning: '#F59E0B',
                info: '#3B82F6',

                light: '#FFF7F5',
                dark: '#3B0A14',

                brand: {
                    border: '#F3D6DC',
                    muted: '#B07A84',
                    mid: '#7A1E2F',
                    low: '#F8E4E8',
                },

                redlux: {
                    DEFAULT: '#9F1D35',
                    dark: '#6E1023',
                    light: '#E8B8C1',
                },

                gold: {
                    50:  '#FDF8E8',
                    100: '#F5EDD6',
                    200: '#E8D48B',
                    300: '#DCC764',
                    400: '#D4AF37',
                    500: '#C9A84C',
                    600: '#A8893B',
                    700: '#8B6F2F',
                    800: '#6E5623',
                    900: '#513D17',
                }
            },
            fontFamily: {
                heading: ['"Playfair Display"', 'serif'],
                body: ['"Inter"', 'sans-serif'],
            },
        }
    },
    plugins: [],
}