module.exports = {
    purge: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    darkMode: 'media', // or 'media' or 'class'
    theme: {
        extend: {
            colors: {
                neon: {
                    light: '#1B98E0',
                    DEFAULT: '#1B98E0',
                    dark: '#033f63',
                    extraDark: '#111827'
                },
                pink: '#FF14BDFF',
                pinkDark: '#31202BFF',
                lime: '#CEFF1A',
                coffee: '#38302E',
                carolinaBlue: '#1B98E0',
                indigoDye: '#033f63'
            }
        },
    },
    variants: {
        extend: {},
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
}
