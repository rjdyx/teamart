require('babel-polyfill')

import 'modules$/bootstrap/dist/css/bootstrap.min.css'
import 'modules$/font-awesome/css/font-awesome.min.css'
import 'modules$/ionicons/dist/css/ionicons.min.css'
import 'modules$/admin-lte/dist/css/AdminLTE.min.css'
import 'modules$/admin-lte/dist/css/skins/skin-green-light.min.css'
import 'modules$/icheck/skins/square/blue.css'
import './css/index.scss'
import 'modules$/bootstrap'
import 'modules$/admin-lte'
import icheck from 'modules$/icheck'

let init = require('js/index.js')
$(function () {
	init.nav()
	init.adduserClick()
	init.checkboxToggle()
})
