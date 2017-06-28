require('expose-loader?$!zepto-webpack')
require('expose-loader?axios!axios')
require('expose-loader?_!lodash')

require('babel-polyfill')

require('swiper/dist/css/swiper.css')
require('font-awesome/css/font-awesome.css')
// require('ionicons/dist/css/ionicons.css')
require('./sass/index.scss')

require('swiper')
require('expose-loader?_valid!./js/validate.js')
require('expose-loader?ajax!./js/ajax.js')
require('expose-loader?prompt!./js/prompt.js')

const prompt = require('./js/prompt.js')

$(function () {
	$('.J_header_category').on('click tap', function () {
		if ($('.header_category').hasClass('left-0')) {
			$('.header_category').removeClass('left-0')
		} else {
			$('.header_category').addClass('left-0')
		}
	})

	let mySwiper = new Swiper('.swiper-container', {
		// Optional parameters
		pagination: '.swiper-pagination',
		paginationClickable: true,
		loop: true
	})
	prompt.init()
})
