exports.message = (msg, url) => {
	$('.prompt').addClass('active').find('.prompt_message_content').html(msg).end()
		.find('.prompt_message').addClass('atc')
	setTimeout(() => {
		if (url) {
			url === 'history' ? history.go(-1) : window.location.href = url
		}
		$('.prompt').removeClass('active').find('.prompt_message_content').html('').end()
			.find('.prompt_message').removeClass('atc')
	}, 1000)
}

// 参数1 信息
// 参数2 确定后的回调函数
exports.question = (msg, fn) => {
	$('.prompt').addClass('active').find('.prompt_question_content').html(msg).end()
		.find('.prompt_question').addClass('atc')
	$('.J_prompt_yes').off('click').on('click', function () {
		fn()
		$('.prompt').removeClass('active').find('.prompt_question_content').html('').end()
			.find('.prompt_question').removeClass('atc')
	})
}
