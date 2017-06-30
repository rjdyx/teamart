// require('expose-loader?$!zepto-webpack')
require('expose-loader?$!jquery')
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
	// header 的事件
	$('.J_show_header_category').on('click tap', function () {
		$('.header_category').addClass('left-0').animate({
			'opacity': 1},
			300,
			function () {
				$('.header_category').find('ul').addClass('left-0')
			}
		)
	})
	$('.J_hide_header_category').on('click tap', function () {
		$('.header_category').removeClass('left-0').animate({
			'opacity': 0},
			300,
			function () {
				$('.header_category').find('ul').removeClass('left-0')
			}
		)
	})
	$('.J_header_search_inp').on('input', function () {
		if ($.trim($(this).val()).length > 0) {
			$(this).siblings('.J_header_search').removeClass('hide')
		} else {
			$(this).siblings('.J_header_search').addClass('hide')
		}
	})
	$('.J_header_search').on('click tap', function () {
		ajax('get', 'url', {query: $('.J_header_search_inp').val()})
			.then(res => {
				console.log(res)
			})
			.catch(err => {
				console.log(err)
			})
	})

	let mySwiper = new Swiper('.swiper-container', {
		// Optional parameters
		pagination: '.swiper-pagination',
		paginationClickable: true,
		loop: true
	})
	prompt.init()
})
