module.exports = {
  content: ['./index.php', './app/**/*.php', './resources/**/*.{php,vue,js}', './src/**/*.{html,js}', './node_modules/tw-elements/dist/js/**/*.js'],
  theme: {
    extend: {
      colors: {
				primary: '#222222',
				secondary: '#9b2e40',
			},
    },
  },
  plugins: [
		require('@tailwindcss/typography'),
		require('tw-elements/dist/plugin'),
	],
};
