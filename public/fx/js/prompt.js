exports.init = () => {
	$('.J_hide_prompt').on('click tap', function () {
		$('.prompt').removeClass('active').find('.prompt_box_content').html('')
	})
}

exports.message = (msg, url) => {
	$('.prompt').addClass('active').find('.prompt_box_content').html(msg)
	if (url) {
		setTimeout(() => {
			window.location.href = url
		}, 1000)
	}
}
