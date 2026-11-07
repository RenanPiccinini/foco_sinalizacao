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
                sans: ['Outfit', 'Inter', ...defaultTheme.fontFamily.sans],
                mono: ['JetBrains Mono', ...defaultTheme.fontFamily.mono],
            },
            colors: {
                foco: {
                    navy: {
                        950: '#020611',
                        900: '#061329',
                        850: '#0a1d3d',
                        800: '#0f2752',
                        700: '#173c7a',
                        600: '#2353a4',
                        500: '#326ed2',
                    },
                    yellow: {
                        300: '#fde047',
                        400: '#fbbf24',
                        500: '#f59e0b',
                        600: '#d97706',
                    },
                    green: {
                        400: '#34d399',
                        500: '#10b981',
                        600: '#059669',
                    },
                    red: {
                        400: '#f87171',
                        500: '#ef4444',
                        600: '#dc2626',
                    },
                    cyan: {
                        400: '#38bdf8',
                        500: '#06b6d4',
                    }
                }
            },
            boxShadow: {
                'glow-yellow': '0 0 30px -5px rgba(245, 158, 11, 0.45)',
                'glow-green': '0 0 35px -5px rgba(16, 185, 129, 0.5)',
                'glow-red': '0 0 35px -5px rgba(239, 68, 68, 0.5)',
                'glow-blue': '0 0 40px -5px rgba(6, 182, 212, 0.35)',
                'card-3d': '0 20px 40px -15px rgba(2, 6, 17, 0.7)',
            },
            animation: {
                'pulse-slow': 'pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                'float-slow': 'float 6s ease-in-out infinite',
                'float-fast': 'float 3.5s ease-in-out infinite',
                'flow-line': 'flowLine 3s linear infinite',
            },
            keyframes: {
                float: {
                    '0%, 100%': { transform: 'translateY(0px)' },
                    '50%': { transform: 'translateY(-12px)' },
                },
                flowLine: {
                    '0%': { strokeDashoffset: '100' },
                    '100%': { strokeDashoffset: '0' },
                }
            }
        },
    },

    plugins: [forms],
};
