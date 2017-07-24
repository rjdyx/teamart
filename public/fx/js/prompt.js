const FastClick = require('fastclick')

exports.init = () => {
	FastClick.attach($('.J_prompt_no')[0])
	$('.J_hide_prompt').on('tap', function () {
		$('.prompt').removeClass('active')
			.find('.prompt_image, .prompt_qrcode, .prompt_message, .prompt_question, .prompt_loading').removeClass('atc').end()
			.find('.prompt_message_content, .prompt_question_content').html('').end()
			.find('.prompt_loading_content').text('加载中').end()
			.find('.prompt_image').find('img').remove()
	})
	// 点击取消时
	$('.J_prompt_no').on('click', function () {
		$('.prompt').removeClass('active').find('.prompt_question_content').html('').end()
			.find('.prompt_question').removeClass('atc')
	})
	// 点击图片时
	// $('.J_prompt_img').on('tap', function () {
	// 	$('.prompt').removeClass('active').find('.prompt_box_content').html('').end()
	// 		.find('.image').addClass('hide')
	// })
}

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
	FastClick.attach($('.J_prompt_yes')[0])
	$('.prompt').addClass('active').find('.prompt_question_content').html(msg).end()
		.find('.prompt_question').addClass('atc')
	$('.J_prompt_yes').off('click').on('click', function () {
		fn()
		$('.prompt').removeClass('active').find('.prompt_question_content').html('').end()
			.find('.prompt_question').removeClass('atc')
	})
}
// 大图
exports.image = (src) => {
	$('.prompt').addClass('active').find('.prompt_image').addClass('atc')
	let img = new Image()
	img.src = src
	img.onload = function () {
		$('.prompt_image').append(img)
	}
	// $('.prompt').find('#p_img').attr('src', src)
}

// 二维码
exports.qrcode = () => {
	$('.prompt').addClass('active').find('.prompt_qrcode').addClass('atc')
}

// 读取
exports.loading = (text) => {
	$('.prompt').addClass('active').find('.prompt_loading').addClass('atc')
	if (text) {
		$('.prompt').find('.prompt_loading_content').text(text)
	}
}

exports.loadingEnd = () => {
	$('.prompt').removeClass('active').find('.prompt_loading').removeClass('atc').find('.prompt_loading_content').text('加载中')
}
