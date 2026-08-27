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
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                display: ['"Space Grotesk"', ...defaultTheme.fontFamily.sans],
                mono: ['"IBM Plex Mono"', ...defaultTheme.fontFamily.mono],
            },
            colors: {
                ink: {
                    DEFAULT: '#12203B',
                    light: '#1D3159',
                    muted: '#64748B',
                },
                paper: '#F4F5F2',
                teal: {
                    DEFAULT: '#0E7C61',
                    light: '#E4F3EE',
                },
                amber: {
                    DEFAULT: '#E8A33D',
                    light: '#FDF2E1',
                },
            },
        },
    },

    plugins: [forms],
};
