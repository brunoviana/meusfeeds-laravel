module.exports = {
    theme: {
      extend: {
        fontFamily: {
          sans: ['Inter var'],
        },
      }
    },
    variants: {},
    plugins: [
      require('@tailwindcss/custom-forms'),
      require('@tailwindcss/ui'),
    ]
  }

//   module.exports = {
//   purge: [
//     './resources/views/**/*.blade.php',
//     './resources/css/**/*.css',
//   ],
//   theme: {
//     extend: {}
//   },
//   variants: {},
//   plugins: [
//     require('@tailwindcss/custom-forms')
//   ]
// }
