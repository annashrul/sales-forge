import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    // Coral brand-color gradient classes used dynamically inside @class() directives
    // can be missed by the content scanner. Safelist to guarantee they compile.
    safelist: [
        'bg-[#FF5A36]',
        'hover:bg-[#FF6B49]',
        'text-[#FF5A36]',
        'text-[#C44425]',
        'bg-[#FFE4DC]',
        'ring-[#FF5A36]/30',
        'ring-[#FF5A36]/20',
        'from-[#FF5A36]',
        'via-[#FF8B65]',
        'via-[#FF8A65]',
        'to-[#FFB088]',
        'to-[#FFD4B8]',
        'shadow-[#FF5A36]/30',
        'shadow-[#FF5A36]/40',
        'shadow-[#FF5A36]/10',
        'focus:border-[#FF5A36]',
        'focus:ring-[#FF5A36]/20',
        'border-[#FF5A36]',
        'bg-[#FF5A36]/10',
        'border-[#FF5A36]/40',
        // Card thumbnail gradients (full strings used in templates)
        'bg-gradient-to-br',
        'from-stone-800',
        'from-stone-700',
        'via-stone-700',
        'via-amber-500',
        'to-amber-500',
        'to-amber-300',
        'from-rose-500',
        'from-rose-400',
        'via-pink-500',
        'via-pink-400',
        'to-yellow-400',
        'to-yellow-300',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
