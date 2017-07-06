const backTop = (container) => {
	$('.J_backTop').on('click tap', function () {
		$('.' + container).scrollTop(0)
	})
}
module.exports = backTop
