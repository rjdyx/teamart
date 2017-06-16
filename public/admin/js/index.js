exports.nav = () => {
	let curhref = window.location.href
	$('.sidebar-menu')
	.find('.active').removeClass('active').end()
	.find('a').each(function (idx, elem) {
		let href = $(this).attr('href')
		if (curhref === href) {
			$(this)
				.parent().addClass('active').end()
				.parents('.treeview').addClass('active')
		}
	})
}
exports.adduserClick = () => {
	$('#addUser,#cancel_addUser').click(function () {
		$('#agentRole').toggle()
		$('#addAgent').toggle()
	})
}
exports.checkboxToggle = () => {
	$('.checkbox-toggle').click(function () {
		var clicks = $(this).data('clicks')
		if (clicks) {
			// Uncheck all checkboxes
			$(".table td input[type='checkbox']").prop('checked', false)
			$('.fa', this).removeClass('fa-check-square-o').addClass('fa-square-o')
		} else {
			// Check all checkboxes
			$(".table td input[type='checkbox']").prop('checked', true)
			$('.fa', this).removeClass('fa-square-o').addClass('fa-check-square-o')
		}
		$(this).data('clicks', !clicks)
	})
}
