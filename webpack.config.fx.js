const path = require('path')
const webpack = require('webpack')
const merge = require('webpack-merge')
const env = require('./env.js')
const baseConfigs = require('./webpack.config.base.js')

function resolve (...dir) {
	return path.join(...dir)
}

const rootPath = resolve(__dirname, 'public')
let app = {
	entry: {
		index: resolve(rootPath, 'fx', 'index.js'),
		valid: resolve(rootPath, 'fx', 'valid.js'),
		swiper: resolve(rootPath, 'fx', 'swiper.js'),
		prompt: resolve(rootPath, 'fx', 'prompt.js'),
		areaSelector: resolve(rootPath, 'fx', 'areaSelector.js'),
		resizeImg: resolve(rootPath, 'fx', 'resizeImg.js'),
		vendors: ['axios']
	},
	output: {
		path: path.join(rootPath, 'fx', 'build'),
		publicPath: env.app_url + 'fx/build/'
	},
	plugins: [
		new webpack.ProvidePlugin({
			axios: 'axios',
			'window.axios': 'axios'
		})
	]
}
app = merge(app, baseConfigs)

module.exports = app
