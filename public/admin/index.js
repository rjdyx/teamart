require('babel-polyfill')

// require('bootstrap/dist/css/bootstrap.min.css')
// require('font-awesome/css/font-awesome.min.css')
// require('ionicons/dist/css/ionicons.min.css')
// require('admin-lte/dist/css/AdminLTE.min.css')
// require('admin-lte/dist/css/skins/skin-green-light.min.css')
// require('icheck/skins/square/blue.css')
require('./css/index.css')
import 'bootstrap'
import 'admin-lte'
import 'icheck'

let init = require('./js/index.js')
$(function () {
	init.nav()
	init.adduserClick()
	init.checkboxToggle()
	console.log(1)
})
