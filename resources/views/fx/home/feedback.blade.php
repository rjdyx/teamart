@extends('layouts.app')

@section('title') 意见反馈 @endsection

@section('css')
@endsection

@section('script')
    @parent
	<script>
		$(function () {
			// 图片上传部分
			function showImg () {
				var $this = $(this)
				var file = this.files[0]
				var idx = parseInt($this.attr('id').substr(-1))
				var id = $this.attr('id')
				var $box = $('label[for="' + id + '"]').parent()
				if (file.size / 1024 > 200) {
					prompt.message('图片太大')
					return false
				}
				if (file.type !== 'image/png' && file.type !== 'image/jpeg') {
					prompt.message('图片格式只支持png和jpg')
					return false
				}
				$box.find('img').remove()
				var fr = new FileReader()
				fr.onload = function(e) {
					if ($box.find('img').length > 0) {
						return
					}
					var img = new Image()
					img.src = e.target.result
					if ($('.feedback_imgs_list').find('li').length < 4) {
						addFile()
					}
					$box.find('.feedback_imgs_list_img').append(img)
					$box.find('img').on('click tap', function () {
						prompt.image($(this).attr('src'))
					})
					$box.find('label').addClass('hide')
					$box.find('.feedback_imgs_list_img').removeClass('hide')
				}
				fr.readAsDataURL(file)
			}
			function addFile () {
				var nid = Date.now()
				var template = `
					<li class="pull-left mr-20 relative">
						<label for="img${nid}">
							<i class="fa fa-camera"></i>
						</label>
						<div class="feedback_imgs_list_img hide">
							<i class="fa fa-times-circle J_remove_img"></i>
						</div>
	                    <input type="file" name="imgs[]" id="img${nid}" class="invisibility J_imgs absolute" accept="image/jpeg,image/jpg,image/png" capture="camera">
	                </li>
				`
				$('.feedback_imgs_list').append(template)
				$('.feedback_imgs_list').find('.J_imgs').off('change', showImg).on('change', showImg)
				$('.feedback_imgs_list').find('.J_remove_img').off('click tap', removeFile).on('click tap', removeFile)
			}
			function removeFile () {
				if ($('.feedback_imgs_list').find('img').length == 4) {
					var id = $(this).parents('li').find('input').attr('id')
					$(this).parent().find('img').remove()
					$(this).parent().addClass('hide').siblings('label').removeClass('hide')
					$(this).parents('li').find('input').remove()
					$(this).parents('li').append(`<input type="file" name="imgs[]" id="${id}" class="invisibility J_imgs absolute" accept="image/jpeg,image/jpg,image/png" capture="camera">`)
					var cl = $(this).parents('li').clone()
					$('.feedback_imgs_list').append(cl)
					$('.J_imgs').off('change', showImg).on('change', showImg)
				}
				$(this).parents('li').remove()
			}
			// 图片变化
			$('.J_imgs').on('change', showImg)
			// 删除图片
			$('.J_remove_img').on('click tap', removeFile)

			$('.J_submit').on('click tap', function () {
				var contact = $.trim($('#contact').val())
				var content = $.trim($('#content').val())
				if (!contact) {
					prompt.message('请输入联系方式')
					return
				}
				if (!/^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+\.([a-zA-Z0-9_-])+/.test(contact) && !/^1[34578]\d{9}$/.test(contact) && !/^[1-9][0-9]{7,}$/.test(contact)) {
					prompt.message('联系方式可以为qq、邮箱、手机')
					return
				}
				if (contact.length > 30) {
					prompt.message('联系方式不能多于30字符')
					return
				}
				if (!content || content.length < 5) {
					prompt.message('反馈内容不少于5字')
					return
				}
				var imgs = []
				$('.J_imgs').each(function () {
					if ($(this)[0].files[0]) {
						imgs.push($(this)[0].files[0])
					}
				})

				var params = {
					contact: contact,
					content: content,
					'imgs[]': imgs
				}
				var url = 'http://'+window.location.host+'/home/feedback';
				ajax('post', url, params, false, true).then(function (res) {
					if (res) {
						prompt.message('反馈成功')
					} else {
						prompt.message('反馈失败')
					}
				})
			})
		})
	</script>
@endsection

@section('content')
	@include("layouts.header-info")
	<div class="feedback">
		<div class="feedback_row">
            <span class="pull-left chayefont fz-18">联系方式</span>
            <input type="text" name="contact" placeholder="QQ/邮箱/电话" id="contact" class="pull-right txt-r chayefont fz-16">
        </div>
        <div class="feedback_row">
            <span class="pull-left chayefont fz-18">反馈内容：</span>
        </div>
        <textarea class="feedback_content" name="content" id="content" placeholder="提出您的建议"></textarea>
        <div class="feedback_imgs mt-20">
			<span>图片：</span>
			<ul class="feedback_imgs_list mt-20 mb-20 clearfix">
				<li class="pull-left mr-20 relative">
					<label for="img1">
						<i class="fa fa-camera"></i>
					</label>
					<div class="feedback_imgs_list_img hide">
						<i class="fa fa-times-circle J_remove_img"></i>
					</div>
					<input type="file" name="imgs[]" id="img1" class="invisibility J_imgs absolute" accept="image/jpeg,image/jpg,image/png" capture="camera">
				</li>
			</ul>
		</div>
        <div class="feedback_bottom">
            <div class="pull-left submit chayefont fz-16 J_submit">提交</div>
            <div class="pull-left cancel chayefont fz-16" onclick="history.go(-1);">取消</div>
        </div>
        <!-- 联系方式 -->
        <!-- 反馈内容 -->
        <!-- 反馈图片 -->
        <!-- 日期时间 -->
	</div>
@endsection
