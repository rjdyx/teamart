const path = require('path')
const webpack = require('webpack')
const merge = require('webpack-merge')
const ExtractTextPlugin = require('extract-text-webpack-plugin')
const env = require('./env.js')

console.dir(process.env.NODE_ENV)
console.dir(process.argv)
let NODE_ENV, current

if (process.env.NODE_ENV) {
	let env = process.env.NODE_ENV
	NODE_ENV = env.toString().split('-')[0]
	current = env.toString().split('-')[0]
} else {
	NODE_ENV = false
	current = process.argv[process.argv.length - 1]
}

function resolve (...dir) {
	return path.join(...dir)
}

// 页面根目录
const rootPath = resolve(__dirname, 'public')

let configs = {
	// 入口
	// entry: {[entryChunkName: string]: string|Array<string>
	entry: {
		// 后台页面引入
		index: resolve(rootPath, 'admin', 'js'),
		// 公共库引入
		vendors: [
			'axios',
			'lodash',
			'jquery'
		]
	},
	// 输出
	output: {
		// 编译文件的文件名(filename)，首选推荐：// main.js || bundle.js || index.js
		// 如果你的配置创建了多个 'chunk'（例如使用多个入口起点或使用类似 CommonsChunkPlugin 的插件），你应该使用以下的替换方式来确保每个文件名都不重复。
		// [name] 被 chunk 的 name 替换。
		// [hash] 被 compilation 生命周期的 hash 替换。
		// [chunkhash] 被 chunk 的 hash 替换。
		filename: '[name].js', // [name].js
		// output.path 对应一个绝对路径，此路径是你希望一次性打包的目录。
		// 导出目录为绝对路径（必选项）。
		// [hash] 被 compilation 生命周期的 hash 替换。
		path: path.join(rootPath, 'admin', 'build'),
		chunkFilename: '[id].[name].js',
		publicPath: path.join(rootPath, 'admin', 'build')
	},
	resolve: {
		extensions: ['.js', '.json'],
		alias: {
			'rootPath': rootPath,
			'modules$': path.join(__dirname, './node_modules')
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
				loader: ExtractTextPlugin.extract(['css-loader', 'style-loader'])
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
				loader: ExtractTextPlugin.extract(['style-loader', 'css-loader!sass-loader'])
			}
		]
	},
	plugins: [
		new ExtractTextPlugin('css/index.css'),
		new webpack.optimize.CommonsChunkPlugin({
			name: 'vendor',
			filename: 'vendor-bundle.js'
		}),
		new webpack.ProvidePlugin({
			axios: 'axios',
			'window.axios': 'axios',

			_: 'lodash',
			'window._': 'lodash',

			$: 'jquery',
			jQuery: 'jquery',
			'window.jQuery': 'jquery',
			'window.$': 'jquery'
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
// webpack(configs)
