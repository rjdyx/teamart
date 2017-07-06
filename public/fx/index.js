require('expose-loader?jquery!jquery')
require('expose-loader?$!zepto-webpack')
require('expose-loader?axios!axios')
require('expose-loader?_!lodash')

require('babel-polyfill')

require('swiper/dist/css/swiper.css')
require('font-awesome/css/font-awesome.css')
require('./css/dropload.css')
// require('ionicons/dist/css/ionicons.css')
require('./sass/index.scss')

require('swiper')
require('expose-loader?_valid!./js/validate.js')
require('expose-loader?ajax!./js/ajax.js')
require('expose-loader?prompt!./js/prompt.js')
require('expose-loader?backTop!./js/backTop.js')
// require('expose-loader?zdropload!./js/zdropload.js')

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
		let v = $(this).siblings('input').val()
		window.location.href = 'http://' + window.location.host + '/home/product/list?name=' + v
	})

	$('.J_backIndex').on('click tap', function () {
		window.location.href = 'http://' + window.location.host
	})

	let mySwiper = new Swiper('.swiper-container', {
		pagination: '.swiper-pagination',
		paginationClickable: true,
		loop: true
	})

	prompt.init()
})
