import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
                heading: ['Syne', 'sans-serif'],
            },
            colors: {
                brutal: {
                    bg: '#F4F1EA',
                    yellow: '#FFC700',
                    red: '#E14D2A',
                    black: '#0D0D0D',
                }
            }
        },
    },

    plugins: [forms],
};
