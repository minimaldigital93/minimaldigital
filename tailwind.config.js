import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    darkMode: 'class',

    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', 'InterVariable', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    50: '#eef2ff', 100: '#e0e7ff', 200: '#c7d2fe', 300: '#a5b4fc',
                    400: '#818cf8', 500: '#6366f1', 600: '#4f46e5', 700: '#4338ca',
                    800: '#3730a3', 900: '#312e81', 950: '#1e1b4b',
                },
                accent: {
                    400: '#34d399', 500: '#10b981', 600: '#059669',
                },
            },
            animation: {
                'float': 'float 7s ease-in-out infinite',
                'float-slow': 'float 11s ease-in-out infinite',
                'gradient-x': 'gradient-x 8s ease infinite',
                'shimmer': 'shimmer 2.2s linear infinite',
                'fade-up': 'fade-up .8s cubic-bezier(.22,1,.36,1) both',
                'pulse-glow': 'pulse-glow 3.5s ease-in-out infinite',
                'spin-slow': 'spin 14s linear infinite',
            },
            keyframes: {
                'float': {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-18px)' },
                },
                'gradient-x': {
                    '0%, 100%': { 'background-position': '0% 50%' },
                    '50%': { 'background-position': '100% 50%' },
                },
                'shimmer': {
                    '0%': { 'background-position': '-500px 0' },
                    '100%': { 'background-position': '500px 0' },
                },
                'fade-up': {
                    from: { opacity: '0', transform: 'translateY(28px)' },
                    to: { opacity: '1', transform: 'translateY(0)' },
                },
                'pulse-glow': {
                    '0%, 100%': { opacity: '.55' },
                    '50%': { opacity: '1' },
                },
            },
            boxShadow: {
                'glow': '0 0 40px -8px rgb(99 102 241 / .45)',
                'glow-accent': '0 0 40px -8px rgb(16 185 129 / .45)',
                'card': '0 1px 2px rgb(0 0 0 / .04), 0 8px 24px -8px rgb(0 0 0 / .12)',
                'card-hover': '0 2px 4px rgb(0 0 0 / .06), 0 24px 48px -12px rgb(0 0 0 / .25)',
            },
            backgroundSize: {
                '300%': '300% 300%',
            },
        },
    },

    plugins: [forms],
};
