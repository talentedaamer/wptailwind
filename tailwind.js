const { colors } = require('tailwindcss/defaultTheme');

module.exports = {
    theme: {
        container: {
            center: true,
        },
        screens: {
            sm: '640px',
            md: '768px',
            lg: '1024px',
            xl: '1170px',
        },
        fontFamily: {
            sans: [
                // '"PT Sans"',
                'Lato',
                'sans-serif'
            ],
            serif: [
                // '"Playfair Display"',
                // 'serif',
                'Raleway',
                'sans-serif',
            ],
        },
        colors: {
            transparent: 'transparent',
            primary: colors.indigo,
            secondary: colors.gray,
            black: colors.black,
            white: colors.white,
            gray: colors.gray,
            red: colors.red,
            yellow: colors.yellow,
            green: colors.green,
            blue: colors.blue,
            indigo: colors.indigo,
            purple: colors.purple,
        }
    },
    variants: {},
    plugins: []
}
