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
            },
            fontFamily: {
                sans: ['Inter', 'system-ui', 'sans-serif'],
                display: ['Playfair Display', 'Georgia', 'serif'],
            },
            boxShadow: {
                card: '0 4px 24px -4px rgba(61, 41, 25, 0.12)',
                sidebar: '4px 0 24px -4px rgba(61, 41, 25, 0.08)',
            },
        },
    },
    plugins: [],
};
