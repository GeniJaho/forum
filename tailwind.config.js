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
                neonSecondary: {
                    light: '#FF14BDFF',
                    DEFAULT: '#FF14BDFF',
                    dark: '#620047',
                    extraDark: '#111827'
                },
                pink: '#FF14BDFF',
                pinkDark: '#620047',
                lime: '#CEFF1A',
                teal: '#02c2a9',
                coffee: '#38302E',
                carolinaBlue: '#1B98E0',
                indigoDye: '#033f63'
            }
        },
        fontFamily: {
            display: ['Menlo', "ui-monospace", "SFMono-Regular", "Monaco", "Consolas", "Liberation Mono", "Courier New", "monospace"],
            body: ['Menlo', "ui-monospace", "SFMono-Regular", "Monaco", "Consolas", "Liberation Mono", "Courier New", "monospace"]
        }
    },
    variants: {
        extend: {},
    },
    plugins: [
        require('@tailwindcss/forms'),
    ],
}
