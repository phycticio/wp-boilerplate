const path = require( 'path' );
const defaults = require( '@wordpress/scripts/config/webpack.config.js' );

module.exports = {
	...defaults,
	entry: {
		app: path.resolve( process.cwd(), 'resources/scripts', 'app.js' ),
		editor: path.resolve( process.cwd(), 'resources/scripts', 'editor.js' ),
	},
	output: {
		filename: '[name].js',
		path: path.resolve( process.cwd(), 'dist' ),
	},
	resolve: {
		...defaults.resolve,
		...{
			alias: {
				...defaults.resolve.alias,
				...{
					'@modycloud': path.resolve(
						process.cwd(),
						'resources/scripts'
					),
					'@mcscss': path.resolve( process.cwd(), 'resources/scss' ),
				},
			},
		},
	},
	module: {
		...defaults.module,
		rules: [
			...defaults.module.rules,
			{
				test: /\.(png|svg|jpg|jpeg|gif)$/i,
				type: 'asset/resource',
			},
			{
				test: /\.(js|jsx)$/,
				exclude: /node_modules/,
				use: {
					loader: 'babel-loader',
					options: {
						presets: [ '@babel/preset-react' ],
					},
				},
			},
		],
	},
};
