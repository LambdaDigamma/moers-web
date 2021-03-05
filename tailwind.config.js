const defaultTheme = require('tailwindcss/defaultTheme')

const colors = require('tailwindcss/colors')

module.exports = {
    purge: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        customForms: theme => ({
            DEFAULT: {
                input: {
                    placeholderColor: theme('colors.gray.300')
                },
            },
        }),
        extend: {
            colors: {
                teal: colors.teal,
                cyan: colors.cyan,
            },
            transitionProperty: {
                'filter': 'filter',
            },
            fontFamily: {
                sans: ['Inter var', ...defaultTheme.fontFamily.sans],
            },
            spacing: {
                '88': '22rem',
            },
            padding: {
                '5/6': '83.3333333%',
                '4/6': '66.6666666%',
                '9/16': '56.25%'
            },
            filter: {
                'none': 'none',
                'grayscale': 'grayscale(1)',
                'invert': 'invert(1)',
                'sepia': 'sepia(1)',
                'blur': 'blur(1px)',
                'brightness-10': 'brightness(10%)',
                'brightness-20': 'brightness(20%)',
                'brightness-30': 'brightness(30%)',
                'brightness-40': 'brightness(40%)',
                'brightness-50': 'brightness(50%)',
                'brightness-60': 'brightness(60%)',
                'brightness-70': 'brightness(70%)',
                'brightness-80': 'brightness(80%)',
                'brightness-90': 'brightness(90%)',
            },
            backdropFilter: {
                'none': 'none',
                'blur': 'blur(20px)',
            },
            maxHeight: {
                xs: '20rem',
                sm: '24rem',
                md: '28rem',
                lg: '32rem',
                xl: '36rem',
                '2xl': '42rem',
                '3xl': '48rem',
                '4xl': '56rem',
                '5xl': '64rem',
                '6xl': '72rem',
            },
            lineClamp: {
                7: '7',
                8: '8',
                9: '9',
                10: '10',
            },
            aspectRatio: {
                17: '17',
                18: '18',
                19: '19',
                20: '20',
                21: '21',
            }
        },
    },
    variants: {
        aspectRatio: ['responsive'],
        backgroundColor: ['responsive', 'hover', 'focus', 'group-hover'],
        borderWidth: ['responsive', 'last', 'hover', 'focus'],
        filter: ['responsive', 'group-hover'],
        objectFit: ['responsive'],
        objectPosition: ['responsive'],
        textColor: ['responsive', 'hover', 'focus', 'group-hover'],
        placeholderColor: ['responsive'],
    },
    plugins: [
        require('@tailwindcss/aspect-ratio'),
        require('@tailwindcss/forms'),
        require('@tailwindcss/line-clamp'),
        require('tailwindcss-filters'),
    ]
}
