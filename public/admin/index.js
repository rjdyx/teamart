require('expose-loader?$!jquery')
require('expose-loader?axios!axios')
require('expose-loader?_!lodash')

require('babel-polyfill')

require('bootstrap/dist/css/bootstrap.css')
require('font-awesome/css/font-awesome.css')
require('ionicons/dist/css/ionicons.css')
require('admin-lte/dist/css/AdminLTE.css')
require('admin-lte/dist/css/skins/skin-green-light.css')
require('icheck/skins/square/blue.css')
require('bootstrap')
require('admin-lte')
require('icheck')
require('./css/index.css')
require('./css/index.scss')

let init = require('./js/index.js')
$(function () {
	init.nav()
	init.adduserClick()
	init.checkboxToggle()
})
