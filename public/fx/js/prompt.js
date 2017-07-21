exports.init = () => {
	$('.J_hide_prompt').on('tap', function () {
		$('.prompt').removeClass('active').find('.prompt_box_content').html('').end()
			.find('.question').addClass('hide').end()
			.find('.message').addClass('hide').end()
			.find('.image').addClass('hide').end()
			.find('#qrcode').addClass('hide').end()
			.find('.prompt_loading').addClass('hide').find('.prompt_loading_text').text('加载中').end()
	})
	// 点击取消时
	$('.J_prompt_no').on('tap', function () {
		$('.prompt').removeClass('active').find('.prompt_box_content').html('').end()
			.find('.question').addClass('hide')
	})
	// 点击图片时
	// $('.J_prompt_img').on('tap', function () {
	// 	$('.prompt').removeClass('active').find('.prompt_box_content').html('').end()
	// 		.find('.image').addClass('hide')
	// })
}

exports.message = (msg, url) => {
	$('.prompt').addClass('active').find('.prompt_box_content').html(msg).end()
		.find('.message').removeClass('hide')
	setTimeout(() => {
		if (url) {
			url === 'history' ? history.go(-1) : window.location.href = url
		}
		$('.prompt').removeClass('active').find('.prompt_box_content').html('')
			.find('.message').addClass('hide')
	}, 1000)
}

// 参数1 信息
// 参数2 确定后的回调函数
exports.question = (msg, fn) => {
	$('.prompt').addClass('active').find('.prompt_box_content').html(msg).end()
		.find('.question').removeClass('hide')
	$('.J_prompt_yes').off('tap').on('tap', function () {
		fn()
		$('.prompt').removeClass('active').find('.prompt_box_content').html('').end()
			.find('.question').addClass('hide')
	})
}
// 大图
exports.image = (src) => {
	$('.prompt').addClass('active').find('.image').removeClass('hide').attr('src', src)
}

// 二维码
exports.qrcode = () => {
	$('.prompt').addClass('active').find('#qrcode').removeClass('hide')
}

// 读取
exports.loading = (text) => {
	$('.prompt').addClass('active').find('.prompt_loading').removeClass('hide')
	if (text) {
		$('.prompt').find('.prompt_loading_text').text(text)
	}
}

exports.loadingEnd = () => {
	$('.prompt').removeClass('active').find('.prompt_loading').addClass('hide').find('.prompt_loading_text').text('加载中')
}
