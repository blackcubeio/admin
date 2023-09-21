const defaultTheme = require('tailwindcss/defaultTheme');
const yiiConf = require('./webpack-yii.json');
const sourcePath = yiiConf.sourceDir + '/' + yiiConf.subDirectories.sources
const colors = require('tailwindcss/colors');
module.exports = {
    content: [
        sourcePath + '/app/**/*.{html,ts}',
        './src/views/**/*.php',
        './src/widgets/views/*.php',
        //'./src/**/*.{html,js}'
        './*.html',
    ],
    theme: {
        extend: {
            fontFamily: {
                // sans: ['Lato', ...defaultTheme.fontFamily.sans],
            },
            screens: {
                // xxl: '1410px',
            },
        },
        colors: {
            transparent: colors.transparent,
            black: colors.black,
            white: colors.white,
            gray: colors.gray,
            red: colors.red,
            green: colors.emerald,
            indigo: colors.slate,
            orange: colors.orange,
            yellow: colors.yellow,
        },
    },
    variants: {
        // borderWidth: ['responsive', 'hover'],
    },
    plugins: [require('@tailwindcss/forms', {
        // strategy: 'base', // only generate global styles
        // strategy: 'class', // only generate classes
    })],
};