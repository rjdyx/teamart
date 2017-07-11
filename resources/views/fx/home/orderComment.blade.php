@extends('layouts.app')

@section('title') 发表评论 @endsection

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
					if ($('.ordercomment_imgs_list').find('li').length < 4) {
						addFile()
					}
					$box.find('.ordercomment_imgs_list_img').append(img)
					$box.find('img').on('click tap', function () {
						prompt.image($(this).attr('src'))
					})
					$box.find('label').addClass('hide')
					$box.find('.ordercomment_imgs_list_img').removeClass('hide')
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
						<div class="ordercomment_imgs_list_img hide">
							<i class="fa fa-times-circle J_remove_img"></i>
						</div>
	                    <input type="file" name="imgs[]" id="img${nid}" class="invisibility J_imgs absolute" accept="image/jpeg,image/jpg,image/png" capture="camera">
	                </li>
				`
				$('.ordercomment_imgs_list').append(template)
				$('.ordercomment_imgs_list').find('.J_imgs').off('change', showImg).on('change', showImg)
				$('.ordercomment_imgs_list').find('.J_remove_img').off('click tap', removeFile).on('click tap', removeFile)
			}
			function removeFile () {
				if ($('.ordercomment_imgs_list').find('img').length == 4) {
					var id = $(this).parents('li').find('input').attr('id')
					$(this).parent().find('img').remove()
					$(this).parent().addClass('hide').siblings('label').removeClass('hide')
					$(this).parents('li').find('input').remove()
					$(this).parents('li').append(`<input type="file" name="imgs[]" id="${id}" class="invisibility J_imgs absolute" accept="image/jpeg,image/jpg,image/png" capture="camera">`)
					var cl = $(this).parents('li').clone()
					$('.ordercomment_imgs_list').append(cl)
					$('.J_imgs').off('change', showImg).on('change', showImg)
				}
				$(this).parents('li').remove()
			}
			// 图片变化
			$('.J_imgs').on('change', showImg)
			// 删除图片
			$('.J_remove_img').on('click tap', removeFile)
			
			ajax('get', '/home/order/comment/product/' + "{{$id}}").then(function (res) {
				var data = res
				if (data.length) {
					addProduct (data)
				} else {
					prompt.message('获取数据失败')
				}
			})

			function addProduct (data) {
				var template = ''
				data.forEach(function (v,k){
					var order_price = v.order_price * v.amount
					var price = v.price * v.amount
					template = `<div class="ordercomment_warpper">
					<div class="ordercomment_warpper_img pull-left mr-20">
						<img src="http://${window.location.host}/${v.thumb}">
					</div>
					<div class="ordercomment_warpper_detail pull-left mr-20">
						<h5 class="chayefont mb-10">${v.name}</h5>
						<p>${v.desc}</p>
					</div>
					<div class="ordercomment_warpper_price pull-left txt-r">
						<span class="block price">&yen;${order_price}</span>
						<del class="block price_raw">&yen;${price}</del>
						<span class="block times">&times;${v.amount}</span>
					</div>
					</div>`
				})
				$(".ordercomment_lists").html(template)
			}

			// 评分
			$('.J_grade').on('click tap', function () {
				var grade = parseInt($(this).data('grade'))
				$('.J_grade').each(function (idx, elem) {
					if (idx <= (grade - 1)) {
						$(this).addClass('active fa-star').removeClass('fa-star-o')
					} else {
						$(this).removeClass('active fa-star').addClass('fa-star-o')
					}
				})
				$('#grade').val(grade)
			})

			// 提交
			$('.J_comment').on('click tap', function () {
				// ajax提交
				if ($.trim($('#content').val()) == '' || $.trim($('#content').val()).length < 5) {
					prompt.message('评价至少要5个字')
					return
				}
				if ($('#grade').val() <= 0) {
					prompt.message('请选择您的满意度')
					return
				}
				var files = []
				$('.J_imgs').each(function () {
					if ($(this)[0].files[0]) {
						files.push($(this)[0].files[0])
					}
				})
				var params = {
					content: $('#content').val(),
					grade: $('#grade').val(),
					'imgs[]': files
				}
				ajax('post', '/home/order/comment/store/'+"{{$id}}", params, false, true)
				.then(function (res) {
					if (res) {
						prompt.message('评论成功！')
						setTimeout(function(){
							window.location.href = 'http://'+window.location.host+'/home/order/list';
						},1000)
					} else {
						prompt.message('服务器繁忙,请稍后再试！')
					}
				})
			})
		})
	</script>
@endsection

@section('content')
	<div class="ordercomment">
		<div class="ordercomment_header">
			<div class="ordercomment_header_left pull-left header_back" onclick="javascript:history.go(-1);">返回</div>
			<a href="javascript:;" class="ordercomment_header_right pull-right chayefont J_comment">发表</a>
			<div class='ordercomment_header_center chayefont'><h2>发表评价</h2></div>
		</div>
		<div class="ordercomment_lists">

		</div>
		<div class="ordercomment_comment mt-20">
			<textarea placeholder="评价" id ="content"></textarea>
		</div>
		<div class="ordercomment_score mt-20 clearfix">
			<span class="pull-left">满意度：</span>
			<div class="ordercomment_score_star pull-left">
				<i class="fa fa-star-o J_grade" data-grade="1"></i>
				<i class="fa fa-star-o J_grade" data-grade="2"></i>
				<i class="fa fa-star-o J_grade" data-grade="3"></i>
				<i class="fa fa-star-o J_grade" data-grade="4"></i>
				<i class="fa fa-star-o J_grade" data-grade="5"></i>
			</div>
			<input type="hidden" id="grade" value="0">
		</div>
		<div class="ordercomment_imgs mt-20">
			<span>晒图：</span>
			<ul class="ordercomment_imgs_list mt-20 clearfix">
				<li class="pull-left mr-20 relative">
					<label for="img1">
						<i class="fa fa-camera"></i>
					</label>
					<div class="ordercomment_imgs_list_img hide">
						<i class="fa fa-times-circle J_remove_img"></i>
					</div>
					<input type="file" name="imgs[]" id="img1" class="invisibility J_imgs absolute" accept="image/jpeg,image/jpg,image/png" capture="camera">
				</li>
			</ul>
		</div>
	</div>
@endsection
