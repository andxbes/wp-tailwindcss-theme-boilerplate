const colors = require('tailwindcss/colors')
module.exports = {
    mode: 'jit',
    future: {
        removeDeprecatedGapUtilities: true,
        purgeLayersByDefault: true,
    },
    purge: {
        content: [
            './*.php',
            './templates/**/*.php',
            './build/js/**/*.js',
        ],
        options: {
            safelist: [],
            blocklist: [],
            keyframes: true,
            fontFace: true,
        },
    },
    // darkMode: 'class',

    theme: {
        container: {
            center: true,
            padding: '1.5rem',
        },
        colors: {
            transparent: 'transparent',
            current: 'currentColor',
            black: colors.black,
            white: colors.white,
            gray: colors.gray,
            red: colors.red,
            green: colors.green,
            blue: {
                // DEFAULT: '#4555E5',
                50: '#f9fafe',
                100: '#F8F9FE',
                150: '#EDEFFE',
                200: '#CBD0F8',
                300: '#9EA7F2',
                400: '#727EEB',
                450: '#697AF6',
                500: '#4555E5',
                600: '#1E31D9',
                650: '#354daf',
                700: '#1827AC',
                800: '#121D7F',
                900: '#0C1352'
            },
            yellow: {
                // DEFAULT: '#FDAE56',
                50: '#FFFFFF',
                100: '#fffaf4',
                200: '#FFF6ED',
                300: '#FEDEBB',
                350: '#FFDF94',
                400: '#FEC688',
                500: '#FDAE56',
                550: '#e09642',
                600: '#FC9624',
                700: '#EA7D03',
                800: '#B86202',
                900: '#854702'
            }
        },
        fontFamily: {
            montserrat: ['Montserrat', 'sans-serif'],
            sans: ['sans-serif'],
            serif: ['Georgia', 'Cambria', '"Times New Roman"', 'Times', 'serif'],
            mono: ['Menlo', 'Monaco', 'Consolas', '"Liberation Mono"', '"Courier New"', 'monospace'],
        },
        fontSize: {
            xs: ['0.75rem', { lineHeight: '1rem' }],
            sm: ['0.875rem', { lineHeight: '1.25rem' }],
            base: ['1rem', { lineHeight: '1.5rem' }],
            lg: ['1.125rem', { lineHeight: '1.75rem' }],
            xl: ['1.25rem', { lineHeight: '1.75rem' }],
            '2xl': ['1.5rem', { lineHeight: '2rem' }],
            '3xl': ['1.875rem', { lineHeight: '2.25rem' }],
            '4xl': ['2.25rem', { lineHeight: '2.5rem' }],
            '5xl': ['3rem', { lineHeight: '1' }],
            '6xl': ['3.75rem', { lineHeight: '1' }],
            '7xl': ['4.5rem', { lineHeight: '1' }],
            '8xl': ['6rem', { lineHeight: '1' }],
            '9xl': ['8rem', { lineHeight: '1' }],
        },
        fontWeight: {
            thin: '100',
            extralight: '200',
            light: '300',
            normal: '400',
            medium: '500',
            semibold: '600',
            bold: '700',
            extrabold: '800',
            black: '900',
        },
        borderRadius: {
            none: '0px',
            sm: '0.125rem',
            DEFAULT: '0.25rem',
            md: '0.375rem',
            lg: '0.5rem',
            xl: '0.75rem',
            '2xl': '1rem',
            '3xl': '1.5rem',
            '4xl': '1.875rem',
            full: '9999px',
        },
        extend: {
            colors: {
                link: {
                    DEFAULT: '#3182ce',
                    'hover': '#63b3ed',
                }
            },
            maxWidth: {
                '300': '18.75rem',
                '400': '25rem',
                '500': '31.25rem',
                '800': '50rem',
                '1/5': 'calc(20% - 0.75rem)',
                '1/4': 'calc(25% - 0.75rem)',
                '1/3': 'calc(33,333% - 0.75rem)',
                '1/2': 'calc(50% - 0.75rem)',
            },
            height: {
                '88': '22rem',
            },
            maxHeight: {
                'v-full': '34.875rem',
                'v-full-md': '34.875rem',
                'v-full-lg': '34.875rem',
                'v-full-xl': '34.875rem',
            },
            minHeight: {
                '25': '25rem',
                '26': '26rem',
                '28': '28rem',
                '680': '42.5rem',
            },
            lineHeight: {
                '12': '3.5rem',
            },
            hueRotate: {
                '-200': '-200deg'
            },
            boxShadow: {
                'group-blue': '8px -8px 0px 0px rgb(163, 174, 246), 16px -16px 0px 0px rgb(205, 211, 252)',
                'group-yellow': '8px -8px 0px 0px rgba(254, 198, 136), 16px -16px 0px 0px rgba(254, 222, 187)'
            },
            lineClamp: {
                8: '8'
            },
            fontSize: {
                xxs: '0.675rem',
            },
            lineHeight: {
                tighter: '1.125',
            },
        }
    },
    variants: {
        textColor: ['responsive', 'hover', 'focus', 'visited'],
    },
    plugins: [
        ({ addUtilities }) => {
            const utils = {
                '.translate-x-half': {
                    transform: 'translateX(50%)',
                },
            };
            addUtilities(utils, ['responsive'])
        },
        require('@tailwindcss/forms'),
        require('@tailwindcss/line-clamp'),
        // require('@tailwindcss/aspect-ratio'),
        require('@tailwindcss/typography')
    ]
};
