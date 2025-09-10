const generateSpacings = (interval = 5, max = 300) => {
  const array = {}
  for (let x = 0; x <= max; x += interval) {
    array[x] = `${x / 10}rem`
  }
  return array
}

module.exports = {
  mode: 'jit',
  content: ['./**/*.{css,scss,php}'],
  theme: {
    spacing: {
      0: '0px',
      10: '1rem',
      18: '1.8rem',
      22: '2.2rem',
      26: '2.6rem',
      30: '3.0rem',
      ...generateSpacings(4, 100),
      ...generateSpacings(8, 256),
    },
    fontFamily: {
      sans: ['neue-haas-grotesk-text', 'system-ui', 'sans-serif'],
      display: ['neue-haas-grotesk-display', 'system-ui', 'sans-serif'],
      slab: ['Stratos', 'system-ui', 'sans-serif'],
    },
    colors: {
      black: '#000',
      white: '#fff',
      fsBlue: {
        50: '#cfdbff',
        100: '#bed0ff',
        200: '#a9c0ff',
        400: '#668fff',
        500: '#3369ff',
        600: '#0548ff',
        800: '#0032bc',
        900: '#002ba0',
        950: '#0a135c',
      },
      fsGrey: {
        50: '#f6f6f6',
        100: '#e7e7e7',
        200: '#d1d1d1',
        300: '#b0b0b0',
        400: '#888888',
        500: '#6d6d6d',
        700: '#4f4f4f',
        800: '#454545',
        900: '#3d3d3d',
        950: '#121212',
      },
      fsRed: {
        600: '#ea3323',
        700: '#c41f11',
      },
      blue: '#2f59ff',
      lime: '#baccab',
    },
    screens: {
      sm: '430px',
      md: '834px',
      lg: '1024px',
      xl: '1280px',
      xxl: '1920px',
    },
    extend: {},
  },
  variants: {
    extend: {},
  },
  plugins: [
    ({ addComponents }) => {
      addComponents({
        '.default-grid': {
          display: 'grid',
          'grid-template-columns': 'repeat(4, minmax(0, 1fr))',
          'column-gap': '2rem',
          '@screen md': {
            'grid-template-columns': 'repeat(8, minmax(0, 1fr))',
            'column-gap': '2rem',
          },
          '@screen xl': {
            'grid-template-columns': 'repeat(12, minmax(0, 1fr))',
            'column-gap': '2.4rem',
          },
          '@screen xxl': {
            'grid-template-columns': 'repeat(12, minmax(0, 1fr))',
            'column-gap': '3rem',
          },
        },
        '.container': {
          maxWidth: '128rem',
          padding: '0 1.6rem',
          width: '100%',
          '@screen md': {
            marginLeft: 'auto',
            marginRight: 'auto',
            padding: '0 2.7rem',
          },
          '@screen xl': {
            padding: '0 2.8rem',
          },
          '@screen xxl': {
            maxWidth: '135rem',
            padding: '0 3rem',
          },
        },
        // use to set up line clamp
        // sepicify the number of lines with -webkit-line-clamp
        '.line-clamp': {
          overflow: 'hidden',
          display: '-webkit-box',
          '-webkit-box-orient': 'vertical',
        },
        '.headline-h1': {
          fontFamily: 'neue-haas-grotesk-display',
          fontWeight: 500,
          fontSize: '6.4rem',
          lineHeight: 0.9,
          '@screen md': {
            fontSize: '5.6rem',
          },
          '@screen xl': {
            fontSize: '6.4rem',
          },
          '@screen xxl': {
            fontSize: '9.6rem',
          },
        },
        '.headline-h2': {
          fontFamily: 'neue-haas-grotesk-display',
          fontWeight: 500,
          fontSize: '5.4rem',
          lineHeight: 1,
          '@screen md': {
            fontSize: '4.8rem',
          },
          '@screen xl': {
            fontSize: '5.6rem',
          },
          '@screen xxl': {
            fontSize: '7.2rem',
          },
        },
        '.headline-h3': {
          fontFamily: 'neue-haas-grotesk-display',
          fontWeight: 450,
          fontSize: '4.8rem',
          lineHeight: 1,
          '@screen md': {
            fontSize: '4rem',
          },
          '@screen xl': {
            fontSize: '4.8rem',
          },
          '@screen xxl': {
            fontSize: '6.4rem',
          },
        },
        '.headline-h4': {
          fontFamily: 'neue-haas-grotesk-display',
          fontWeight: 500,
          fontSize: '4rem',
          lineHeight: 1,
          '@screen md': {
            fontSize: '3.2rem',
          },
          '@screen xl': {
            fontSize: '4rem',
          },
          '@screen xxl': {
            fontSize: '5.6rem',
          },
        },
        '.headline-h5': {
          fontFamily: 'neue-haas-grotesk-display',
          fontWeight: 500,
          fontSize: '3.2rem',
          lineHeight: 1,
          '@screen md': {
            fontSize: '2.4rem',
          },
          '@screen xl': {
            fontSize: '3.2rem',
          },
          '@screen xxl': {
            fontSize: '4.8rem',
          },
        },
        '.headline-h6': {
          fontFamily: 'neue-haas-grotesk-display',
          fontWeight: 500,
          fontSize: '2.4rem',
          lineHeight: 1,
          '@screen xxl': {
            fontSize: '3.2rem',
          },
        },
        '.body-copy-1': {
          fontFamily: 'neue-haas-grotesk-text, system-ui, sans-serif',
          fontSize: '1.6rem',
          lineHeight: 1.4,

          '@screen md': {
            fontSize: '1.4rem',
          },

          '@screen xl': {
            fontSize: '1.6rem',
          },

          '@screen xxl': {
            fontSize: '2rem',
          },
        },
        '.body-copy-2': {
          fontFamily: 'neue-haas-grotesk-text, system-ui, sans-serif',
          fontSize: '1.4rem',
          lineHeight: 1.4,
          '@screen md': {
            fontSize: '1.2rem',
          },
          '@screen xl': {
            fontSize: '1.4rem',
          },
          '@screen xxl': {
            fontSize: '1.6rem',
          },
        },
        '.body-copy-3': {
          fontFamily: 'neue-haas-grotesk-text, system-ui, sans-serif',
          fontSize: '1.2rem',
          lineHeight: 1.4,
          '@screen xxl': {
            fontSize: '1.4rem',
          },
        },
        '.card-title': {
          fontFamily: 'Stratos, system-ui, sans-serif',
          fontWeight: 500,
          fontSize: '1.8rem',
          lineHeight: 1,
          textTransform: 'uppercase',
        },
        '.button-label': {
          fontFamily: 'Stratos, system-ui, sans-serif',
          fontWeight: 500,
          fontSize: '1.2rem',
          lineHeight: 1,
          textTransform: 'uppercase',

          '@screen md': {
            fontSize: '1.4rem',
          },
        },
        '.caption-label': {
          fontFamily: 'Stratos, system-ui, sans-serif',
          fontWeight: 500,
          fontSize: '1.2rem',
          lineHeight: 1,
          textTransform: 'uppercase',
        },
        '.caption-gallery': {
          fontFamily: 'neue-haas-grotesk-display',
          fontWeight: 400,
          fontSize: '1.4rem',
          lineHeight: '140%',
        },
        '.body-legal': {
          fontSize: '1rem',
          lineHeight: 1.4,
        },
        '.copy-medium': {
          fontWeight: 500,
        },
        '.copy-bold': {
          fontWeight: 600,
        },
      })
    },
  ],
}
