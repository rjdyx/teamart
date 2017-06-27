// axios.interceptors.request.use(function (config) {
//     // Do something before request is sent
//     config.headers = Object.assign(config.headers,{'X-CSRF-TOKEN': Laravel.csrfToken})
// 	return config
// }, function (error) {
//     // Do something with request error
// 	return Promise.reject(error)
// });

// // Add a response interceptor
// axios.interceptors.response.use(function (response) {
//     // Do something with response data
//     return response
// }, function (error) {
//     // Do something with response error
//     return Promise.reject(error)
// })

require('expose-loader?$!zepto-webpack')
require('expose-loader?axios!axios')
require('expose-loader?_!lodash')

require('babel-polyfill')

// require('normalize.css')
require('swiper/dist/css/swiper.css')
require('font-awesome/css/font-awesome.css')
// require('ionicons/dist/css/ionicons.css')
// require('bootstrap')
require('./sass/index.scss')

require('swiper')
require('expose-loader?_valid!./js/validate.js')
// require('expose-loader?datepicker!./js/datepicker.js')

// console.log($)

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
})
