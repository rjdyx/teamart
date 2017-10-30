const path = require('path')
const webpack = require('webpack')
const merge = require('webpack-merge')
const baseConfig = require('./webpack.config.base.js')

function resolve (...dir) {
	return path.join(...dir)
}

const rootPath = resolve(__dirname, 'public')
let app = {
	entry: {
		index: resolve(rootPath, 'admin'),
		vendors: ['axios', 'jquery']
	},
	output: {
		path: path.join(rootPath, 'admin', 'build'),
		publicPath: env.app_url + 'admin/build/'
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
app = merge(app, baseConfig)

module.exports = app
