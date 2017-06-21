$(function() {
	function showImg () {
		var $this = $(this)
		var file = this.files[0]
		var id = parseInt($this.attr('id').substr(-1))
		if (!validimg('img', file)) {
			return
		}
		$this.parent().find('img').remove()
		var fr = new FileReader()
		fr.onload = function(e) {
			if ($this.parent().find('img').length > 0) {
				return
			}
			var img = new Image()
			img.src = e.target.result
			img.classList.add('pull-left')
			img.classList.add('upload_img')
			if ($('.upload_box').length < 4 && $('#img' + (id + 1)).length == 0) {
				addFile(id)
			}
			$this.parents('.upload_box').prepend(img).end()
				.siblings('.invisible').removeClass('invisible')
				.siblings('.upload').addClass('hidden')
		}
		fr.readAsDataURL(file)
	}
	function addFile (id) {
		var nid = parseInt(id) + 1
		var template = '<div class="upload_box pull-left ml-10 mt-10"><label for="img' + nid + '" class="upload pull-left"><i class="glyphicon glyphicon-plus"></i></label><label class="btn btn-primary pull-left invisible ml-10" for="img' + nid + '">修改</label><div class="btn btn-danger pull-left invisible ml-10 mt-10 J_remove">删除</div><input type="file" name="imgs[]" id="img' + nid + '" class="form-control invisible J_img" accept="image/jpeg,image/jpg,image/png"></div>'
		$('.upload_list').append(template)
			.find('.J_img').on('change', showImg).end()
			.find('.J_remove').on('click', removeFile)
	}
	function removeFile () {
		var id = $(this).siblings('label').attr('for').substr(-1)
		$(this).addClass('invisible')
			.siblings('img').remove().end()
			.siblings('.btn').addClass('invisible').end()
			.siblings('.upload').removeClass('hidden').end()
			// .siblings('input')[0].outerHTML = ''
			.siblings('input').remove().end()
			.parent().append('<input type="file" name="imgs[]" id="img' + id + '" class="invisible form-control J_img" accept="image/jpeg,image/jpg,image/png">')
			.find('.J_img').on('change', showImg)
	}
	$('.J_img').on('change', showImg)
	$('.J_remove').on('click', removeFile)
})
