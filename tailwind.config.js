import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            screens: {
                "8xl": "88rem",
                "9xl": "96rem",
                "10xl": "104rem",
            },
            maxWidth: {
                "8xl": "88rem",
                "9xl": "96rem",
                "10xl": "104rem",
            },
            fontFamily: {
                sans: ['"DM Sans"', ...defaultTheme.fontFamily.sans],
                inter: ["Inter", ...defaultTheme.fontFamily.sans],
                cambay: ["Cambay", ...defaultTheme.fontFamily.sans],
                poppins: ["poppins", ...defaultTheme.fontFamily.sans],
                poppins: ["Poppins", ...defaultTheme.fontFamily.sans],
                bengali: [
                    '"Noto Sans Bengali"',
                    ...defaultTheme.fontFamily.sans,
                ],
            },
            colors: {
                primary: "#ea2f30",
                accent: "#b16130",
                "primary-light": "#fee2e2",
                "primary-dark": "#b91c1c",
                "accent-light": "#fed7aa",
                "accent-dark": "#c2410c",
            },
            animation: {
                "flash-slide-in": "slideInRight 0.3s ease-out",
                "flash-slide-out": "slideOutRight 0.3s ease-in",
                "flash-progress": "progressShrink linear forwards",
            },
            keyframes: {
                fadeIn: {
                    "0%": { opacity: "0" },
                    "100%": { opacity: "1" },
                },
                slideUp: {
                    "0%": { transform: "translateY(10px)", opacity: "0" },
                    "100%": { transform: "translateY(0)", opacity: "1" },
                },
                slideInRight: {
                    "0%": { transform: "translateX(100%)", opacity: "0" },
                    "100%": { transform: "translateX(0)", opacity: "1" },
                },
                slideOutRight: {
                    "0%": { transform: "translateX(0)", opacity: "1" },
                    "100%": { transform: "translateX(100%)", opacity: "0" },
                },
                progressShrink: {
                    "0%": { width: "100%" },
                    "100%": { width: "0%" },
                },
            },
        },
    },

    plugins: [
        forms,
        function ({ addUtilities }) {
            addUtilities({
                ".no-scrollbar::-webkit-scrollbar": {
                    display: "none",
                },
                ".no-scrollbar": {
                    "-ms-overflow-style": "none",
                    "scrollbar-width": "none",
                },
            });
        },
    ],
};
