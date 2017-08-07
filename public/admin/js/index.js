exports.nav = () => {
	let curpath = window.location.pathname
	$('.sidebar-menu')
	.find('.active').removeClass('active').end()
	.find('a').each(function (idx, elem) {
		let href = $(this).attr('href')
		let hreflength = href.indexOf('admin')
		let curlength = curpath.indexOf('admin')
		if (hreflength > 0) {
			href = href.substr(hreflength + 6)
		}
		if (curlength > 0) {
			curpath = curpath.substr(curlength + 6)
			let curarr = curpath.split('/')
			if (curarr.length > 2) {
				curarr.length = 2
			}
			curpath = curarr.join('/')
		}
		if (curpath === href || (href === 'activity/group' && curpath === 'activity/activityproduct')) {
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
