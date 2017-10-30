const path = require('path')
const webpack = require('webpack')
const merge = require('webpack-merge')
const ExtractTextPlugin = require('extract-text-webpack-plugin')
const HtmlWebpackPlugin = require('html-webpack-plugin')
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
