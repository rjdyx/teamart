$(function () {
	var operation = {
		// 输入框的基本操作
		search: function () {
			$('.search').keyup(function () {
				var inputText = $('.search').val()
				if (inputText != '') {
					$('.close').show()
				} else {
					$('.close').hide()
				}
				$('.close').click(function () {
					$('.search').val('') // 清空输入框内容
					$('.close').hide()
				})
				if (event.keyCode == '13') { // keyCode=13是回车键
					$('.search_img').click()
				}
				$('.search_img').click(function () {
					// todo 搜索
				})
			})
		}
	}
	operation.search()
})
