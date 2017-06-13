export default {
	nav: function () {
		let curhref = window.location.href
		console.log(curhref)
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
	},
	adduserClick: function () {
		$('#addUser,#cancel_addUser').click(function () {
			$('#agentRole').toggle()
			$('#addAgent').toggle()
		})
	},
	checkboxToggle: function () {
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
}
