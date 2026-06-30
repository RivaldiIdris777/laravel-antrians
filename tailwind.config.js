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
                 sans: ['Nunito', ...defaultTheme.fontFamily.sans],
                 jakarta: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: '#0B3056',
                secondary: '#F29222',
                accent: '#4a69bd',
                dark: '#1a1a1a',
                light: '#f5f5f5',
                brand: {
                    DEFAULT: '#1e56d9',
                    dark: '#1740b0',
                    light: '#3b72f6',
                    muted: '#1e40af',
                },
            },
        },
    },

    plugins: [forms],
};
