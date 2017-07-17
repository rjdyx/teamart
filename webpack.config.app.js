const path = require('path')
const webpack = require('webpack')
const env = require('./env.js')

function resolve (...dir) {
	return path.join(...dir)
}

const rootPath = resolve(__dirname, 'public')
let app
if (env.isAdmin) {
	app = {
		entry: {
			index: resolve(rootPath, 'admin'),
			vendors: ['axios', 'jquery']
		},
		output: {
			path: path.join(rootPath, 'admin', 'build'),
			publicPath: env.isServer ? path.join('public', 'admin', 'build/') : env.app_url + 'admin/build/'
		},
		plugins: [
			new webpack.ProvidePlugin({
				axios: 'axios',
				'window.axios': 'axios',
				$: 'jquery',
				jQuery: 'jquery',
				'window.jQuery': 'jquery',
				'window.$': 'jquery'
			})
		]
	}
} else {
	app = {
		entry: {
			index: resolve(rootPath, 'fx', 'index.js'),
			valid: resolve(rootPath, 'fx', 'valid.js'),
			swiper: resolve(rootPath, 'fx', 'swiper.js'),
			prompt: resolve(rootPath, 'fx', 'prompt.js'),
			areaSelector: resolve(rootPath, 'fx', 'areaSelector.js'),
			vendors: ['axios']
		},
		output: {
			path: path.join(rootPath, 'fx', 'build'),
			publicPath: env.isServer ? path.join('public', 'fx', 'build/') : env.app_url + 'fx/build/'
		},
		plugins: [
			new webpack.ProvidePlugin({
				axios: 'axios',
				'window.axios': 'axios'
			})
		]
	}
}

module.exports = app
