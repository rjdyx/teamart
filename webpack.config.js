const path = require('path');
const webpack = require('webpack');
const merge = require('webpack-merge');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const env = require('./env.js')

function resolve (...dir) {
	return path.join(...dir);
}

// 页面根目录
const rootPath = resolve(__dirname, 'public');

let configs = {
	// 入口
	// entry: {[entryChunkName: string]: string|Array<string>
	entry: {
		// 手机端引入
		webapp: resolve(rootPath, 'fx', 'js'),

		// 后台页面引入
		admin: resolve(rootPath, 'admin', 'js'),
		// 公共库引入
		vendors: [
			'axios',
			'lodash',
			'jQuery',
			'bootstrap'
		]
	},
	// 输出
	output: {
		// 编译文件的文件名(filename)，首选推荐：// main.js || bundle.js || index.js
		// 如果你的配置创建了多个 "chunk"（例如使用多个入口起点或使用类似 CommonsChunkPlugin 的插件），你应该使用以下的替换方式来确保每个文件名都不重复。
		// [name] 被 chunk 的 name 替换。
		// [hash] 被 compilation 生命周期的 hash 替换。
		// [chunkhash] 被 chunk 的 hash 替换。
		filename: '[id].[name].[chunkhash].js', // [name].js
		// output.path 对应一个绝对路径，此路径是你希望一次性打包的目录。
		// 导出目录为绝对路径（必选项）。
		// [hash] 被 compilation 生命周期的 hash 替换。
		path: path.join(__dirname, 'public', 'build'), // "/home/proj/cdn/assets/[hash]",
		// 非入口的 chunk(non-entry chunk) 的文件名，路径相对于 output.path 目录。
		chunkFilename: '[id].[name].[chunkhash].[hash].js',
		publicPath: path.join(__dirname, 'public')  // "http://cdn.example.com/assets/[hash]/"
	},
	resolve: {
		extensions: ['.js', '.json'],
		alias: {
			'rootPath': rootPath,
		}
	},
	module: {
		rules: [
			{
				test: /\.js$/,
				loader: 'eslint-loader',
				enforce: 'pre',
				include: [rootPath],
				options: {
					formatter: require('eslint-friendly-formatter')
				}
			},
			{
				test: /\.js$/,
				loader: 'babel-loader',
				include: [rootPath]
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
				loader: 'file-loader',
                query: {
                  name: '[name].[ext]?[hash]'
                }
				// loader: 'url-loader',
				// options: {
				// 	limit: 10000,
				// 	name: resolve('public', 'img/[name].[hash:7].[ext]')
				// }
			},
			{
				test: /\.(woff2?|eot|ttf|otf)(\?.*)?$/,
				loader: 'file-loader'
				// loader: 'url-loader',
				// options: {
				// 	limit: 10000,
				// 	name: resolve('public', 'fonts/[name].[hash:7].[ext]')
				// }
			},
			{
                test: /\.scss$/,
                loader: ExtractTextPlugin.extract(['style-loader', 'css-loader!sass-loader?sourceMap'])
            },
		]
	},
	plugins: [
		new ExtractTextPlugin('css/[name].css'),
		new webpack.optimize.CommonsChunkPlugin({
          name: 'vendor',
          filename: 'js/vendor-bundle.js'
        }),
		new webpack.ProvidePlugin({
			$: 'jquery',
			jQuery: 'jquery',
			'window.jQuery': 'jquery',
			'window.$': 'jquery',

			_: 'lodash',
			'window._': 'lodash',

			axios: 'axios',
			'window.axios': 'axios'
		}),
		new webpack.optimize.UglifyJsPlugin({
			compress: {
				warnings: false
			}
		})
	]
};



module.exports = configs;
// webpack(configs);
