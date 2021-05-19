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
                    light: '#FF14BDFF',
                    DEFAULT: '#FF14BDFF',
                    dark: '#31202BFF',
                },
                lime: '#CEFF1A',
                coffee: '#38302E',
                carolinaBlue: '#1B98E0'
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
