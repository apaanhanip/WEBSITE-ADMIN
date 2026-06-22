/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './app/View/Components/**/*.php',
    ],
    theme: {
        extend: {
            colors: {
                coffee: {
                    50: '#faf6f1',
                    100: '#f0e6d8',
                    200: '#e0cdb3',
                    300: '#c9a87a',
                    400: '#b08552',
                    500: '#8b5e34',
                    600: '#6f4a2a',
                    700: '#5a3b22',
                    800: '#4a3120',
                    900: '#3d2919',
                    950: '#21150c',
                },
            cream: {
                50: '#fffdf8',
                100: '#fef9ee',
                200: '#fdf3dc',
                300: '#fae8c0',
            },
            accent: {
                50: '#fdf8ed',
                100: '#f8eccc',
                200: '#f0d795',
                300: '#e7bd5e',
                400: '#e0a838',
                500: '#d8901f',
                600: '#bf7117',
                700: '#9f5316',
                800: '#824218',
                900: '#6d3717',
            },
        },
        fontFamily: {
            sans: ['Inter', 'system-ui', 'sans-serif'],
            display: ['Playfair Display', 'Georgia', 'serif'],
        },
        boxShadow: {
            card: '0 4px 24px -4px rgba(61, 41, 25, 0.12)',
            'card-hover': '0 16px 40px -8px rgba(61, 41, 25, 0.22)',
            sidebar: '4px 0 24px -4px rgba(61, 41, 25, 0.08)',
            glow: '0 8px 30px -6px rgba(216, 144, 31, 0.45)',
        },
        backgroundImage: {
            'coffee-gradient': 'linear-gradient(135deg, #3d2919 0%, #5a3b22 45%, #8b5e34 100%)',
            'accent-gradient': 'linear-gradient(135deg, #d8901f 0%, #bf7117 100%)',
        },
        keyframes: {
            'fade-in': {
                '0%': { opacity: '0' },
                '100%': { opacity: '1' },
            },
            'fade-up': {
                '0%': { opacity: '0', transform: 'translateY(12px)' },
                '100%': { opacity: '1', transform: 'translateY(0)' },
            },
            float: {
                '0%, 100%': { transform: 'translateY(0)' },
                '50%': { transform: 'translateY(-6px)' },
            },
        },
        animation: {
            'fade-in': 'fade-in 0.4s ease-out both',
            'fade-up': 'fade-up 0.5s ease-out both',
            float: 'float 4s ease-in-out infinite',
        },
    },
},
    plugins: [],
};
