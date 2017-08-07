const path = require('path')
const webpack = require('webpack')
const merge = require('webpack-merge')
const ExtractTextPlugin = require('extract-text-webpack-plugin')
const HtmlWebpackPlugin = require('html-webpack-plugin')
const app = require('./webpack.config.app.js')
const env = require('./env.js')

function resolve (...dir) {
	return path.join(...dir)
}

// 页面根目录
const rootPath = resolve(__dirname, 'public')

let configs = {
	output: {
		filename: '[name].js',
		chunkFilename: '[id].[name].js'
	},
	resolve: {
		extensions: ['.js', '.json'],
		alias: {
			'rootPath': rootPath
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
			// {
			// 	test: require.resolve('axios'),
			// 	use: [
			// 		{
			// 			loader: 'expose-loader',
			// 			options: 'axios'
			// 		}
			// 	]
			// }
			// {
			// 	test: require.resolve('lodash'),
			// 	use: [
			// 		{
			// 			loader: 'expose-loader',
			// 			options: '_'
			// 		}
			// 	]
			// }
		]
	},
	plugins: [
		new ExtractTextPlugin('css/index.css'),
		new webpack.optimize.CommonsChunkPlugin({
			name: 'vendor',
			filename: 'vendor-bundle.js'
		})
	],
	node: {
		fs: 'empty',
		module: 'empty'
	}
}
configs = merge(configs, app)
// if (env.isAdmin) {
// 	configs = merge(configs, {
// 		module: {
// 			rules: [
// 				{
// 					test: require.resolve('jquery'),
// 					use: [
// 						{
// 							loader: 'expose-loader',
// 							options: 'jquery'
// 						},
// 						{
// 							loader: 'expose-loader',
// 							options: '$'
// 						}
// 					]
// 				}
// 			]
// 		}
// 	})
// } else {
// 	configs = merge(configs, {
// 		module: {
// 			loaders: [
// 				// {
// 				// 	test: require.resolve('zepto'),
// 				// 	use: [
// 				// 		{
// 				// 			loader: 'expose-loader?window.Zepto!script-loader',
// 				// 			options: '$'
// 				// 		}
// 				// 	]
// 				// }
// 				{
// 					test: require.resolve('zepto-webpack'),
// 					use: [
// 						{
// 							loader: 'expose-loader',
// 							options: '$'
// 						}
// 					]
// 				},
// 				{
// 					test: require.resolve('jquery'),
// 					use: [
// 						{
// 							loader: 'expose-loader',
// 							options: 'jquery'
// 						}
// 					]
// 				}
// 			]
// 		}
// 	})
// }

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
			port: env.port,
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
