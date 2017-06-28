exports.init = () => {
	$('.J_hide_prompt').on('click tap', function () {
		$('.prompt').addClass('hide').find('.prompt_box_content').html('')
	})
}

exports.message = (msg, url) => {
	$('.prompt').removeClass('hide').find('.prompt_box_content').html(msg)
	if (url) {
		setTimeout(() => {
			window.location.href = url
		}, 1000)
	}
}
