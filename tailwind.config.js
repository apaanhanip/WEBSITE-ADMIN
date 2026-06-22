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
                // "coffee" is repurposed as the neutral gray scale (text/borders).
                coffee: {
                    50: '#f8fafc',
                    100: '#eef1f6',
                    200: '#e2e8f0',
                    300: '#cbd5e1',
                    400: '#94a3b8',
                    500: '#64748b',
                    600: '#475569',
                    700: '#334155',
                    800: '#1e293b',
                    900: '#0f172a',
                    950: '#020617',
                },
                // "cream" is repurposed as light surfaces/backgrounds.
                cream: {
                    50: '#f7f8fb',
                    100: '#eef1f6',
                    200: '#e6eaf1',
                    300: '#dbe1ea',
                },
                // Primary brand color (red), matching the shared design.
                brand: {
                    50: '#fef2f2',
                    100: '#fee2e2',
                    200: '#fecaca',
                    300: '#fca5a5',
                    400: '#f87171',
                    500: '#ef4444',
                    600: '#dc2626',
                    700: '#b91c1c',
                    800: '#991b1b',
                    900: '#7f1d1d',
                },
                accent: {
                    50: '#fff7ed',
                    100: '#ffedd5',
                    200: '#fed7aa',
                    300: '#fdba74',
                    400: '#fb923c',
                    500: '#f97316',
                    600: '#ea580c',
                    700: '#c2410c',
                    800: '#9a3412',
                    900: '#7c2d12',
                },
            },
        fontFamily: {
            sans: ['Inter', 'system-ui', 'sans-serif'],
            display: ['Playfair Display', 'Georgia', 'serif'],
        },
        boxShadow: {
            card: '0 1px 3px rgba(15, 23, 42, 0.05), 0 8px 24px -10px rgba(15, 23, 42, 0.12)',
            'card-hover': '0 12px 32px -8px rgba(15, 23, 42, 0.18)',
            sidebar: '0 0 24px -6px rgba(15, 23, 42, 0.08)',
            glow: '0 8px 24px -6px rgba(239, 68, 68, 0.45)',
        },
        backgroundImage: {
            'brand-gradient': 'linear-gradient(135deg, #f87171 0%, #ef4444 55%, #dc2626 100%)',
            'coffee-gradient': 'linear-gradient(135deg, #b91c1c 0%, #dc2626 50%, #ef4444 100%)',
            'accent-gradient': 'linear-gradient(135deg, #f87171 0%, #dc2626 100%)',
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
