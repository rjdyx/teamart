require('swiper')
$(function () {
	let mySwiper = new Swiper('.swiper-container', {
		pagination: '.swiper-pagination',
		paginationClickable: true,
		loop: true,
		autoplay: 2500,
		autoplayDisableOnInteraction: false
	})
})
