require('expose-loader?$!zepto-webpack')
require('expose-loader?axios!axios')
require('expose-loader?_!lodash')

require('babel-polyfill')

// require('normalize.css')
// require('mobile-select-area/dist/mobile-select-area.css')
// require('mobile-select-area/dist/dialog.css')
require('font-awesome/css/font-awesome.css')
require('ionicons/dist/css/ionicons.css')
// require('bootstrap')
require('./css/index.css')
require('./sass/index.scss')

require('expose-loader?_valid!./js/validate.js')
// require('expose-loader?datepicker!./js/datepicker.js')

require('./js/index.js')
// console.log($)
