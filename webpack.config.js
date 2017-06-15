const path = require('path')
const webpack = require('webpack')
const merge = require('webpack-merge')
const ExtractTextPlugin = require('extract-text-webpack-plugin')
const env = require('./env.js')

function resolve (...dir) {
	return path.join(...dir)
}

// 页面根目录
const rootPath = resolve(__dirname, 'public')

const globalValue = env.isAdmin ? {
	axios: 'axios',
	'window.axios': 'axios',

	_: 'lodash',
	'window._': 'lodash',

	$: 'jquery',
	jQuery: 'jquery',
	'window.jQuery': 'jquery',
	'window.$': 'jquery'
} : {
	axios: 'axios',
	'window.axios': 'axios',

	_: 'lodash',
	'window._': 'lodash',

	$: 'zetop',
	'window.$': 'zetop'
}

let configs = {
	entry: {
		index: env.isAdmin ? resolve(rootPath, 'admin') : resolve(rootPath, 'fx'),
		vendors: env.isAdmin ? ['axios', 'lodash', 'jquery'] : ['axios', 'lodash', 'zetop']
	},
	output: {
		filename: '[name].js',
		path: env.isAdmin ? path.join(rootPath, 'admin', 'build') : path.join(rootPath, 'fx', 'build'),
		chunkFilename: '[id].[name].js',
		publicPath: env.isAdmin ? path.join(rootPath, 'admin', 'build') : path.join(rootPath, 'fx', 'build')
	},
	resolve: {
		extensions: ['.js', '.json'],
		alias: {
			'rootPath': rootPath,
			'sass': resolve(__dirname, 'public', 'css')
		}
	},
	module: {
		rules: [
			{
				test: /\.js$/,
				loader: 'eslint-loader',
				enforce: 'pre',
				options: {
					formatter: require('eslint-friendly-formatter')
				}
			},
			{
				test: /\.js$/,
				loader: 'babel-loader'
			},
			{
				test: /\.css$/,
				use: ExtractTextPlugin.extract({
					fallback: 'style-loader',
					use: ['css-loader']
				})
			},
			{
				test: /\.json$/,
				loader: 'json-loader'
			},
			{
				test: /\.(png|jpe?g|gif|svg)(\?.*)?$/,
				loader: 'file-loader'
			},
			{
				test: /\.(woff2?|eot|ttf|otf)(\?.*)?$/,
				loader: 'file-loader'
			},
			{
				test: /\.scss$/,
				use: ExtractTextPlugin.extract({
					fallback: 'style-loader',
					use: ['css-loader', 'sass-loader']
				})
			}
		]
	},
	plugins: [
		new ExtractTextPlugin('css/index.css'),
		new webpack.optimize.CommonsChunkPlugin({
			name: 'vendor',
			filename: 'vendor-bundle.js'
		}),
		new webpack.ProvidePlugin(globalValue)
	],
	node: {
		fs: 'empty',
		module: 'empty'
	}
}

if (process.env.NODE_ENV === 'development') {
	configs = merge(configs, {
		plugins: [
			new webpack.DefinePlugin({
				'process.env.NODE.ENV': 'development'
			}),
			new webpack.HotModuleReplacementPlugin()
		],
		devServer: {
			historyApiFallback: true,
			inline: true,
			port: 8080,
			proxy: {
				'/**': {
					changeOrigin: true,
					target: env.app_url,
					secure: false
				}
			}
		}
	})
} else {
	configs = merge(configs, {
		plugins: [
			// minify JS
			new webpack.optimize.UglifyJsPlugin({
				compress: {
					warnings: false
				}
			})
		]
	})
}

module.exports = configs
