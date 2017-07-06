const backTop = (container) => {
	$('.J_backTop').on('click tap', function () {
		$('.' + container).animate({
			'scrollTop': 0
		}, 100)
	})
}
module.exports = backTop
