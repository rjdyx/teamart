@extends('layouts.app')

@section('title') 发表评论 @endsection

@section('css')
@endsection

@section('script')
	@parent
	<script src="{{url('/fx/build/resizeImg.js')}}"></script>
	<script>
		$(function () {
			// 图片上传部分
			function showImg () {
				var $this = $(this)
				var file = this.files[0]
				var pid = $this.parents('.ordercomment_container').data('id')
				var id = $this.attr('id')
				var $box = $('label[for="' + id + '"]').parent()
				// if (file.size / 1024 > 200) {
				// 	fxPrompt.message('图片太大')
				// 	return false
				// }
				if (file.type !== 'image/png' && file.type !== 'image/jpeg') {
					fxPrompt.message('图片格式只支持png和jpg')
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
					if ($this.parents('.ordercomment_imgs_list').find('li').length < 4) {
						addFile($this)
					}
					$box.find('.ordercomment_imgs_list_img').append(img)
					$box.find('img').on('tap', function () {
						fxPrompt.image($(this).attr('src'))
					})
					$box.find('label').addClass('hide')
					$box.find('.ordercomment_imgs_list_img').removeClass('hide')
				}
				fr.readAsDataURL(file)
			}
			function addFile ($elem) {
				var pid = $elem.parents('.ordercomment_container').data('id')
				var nid = Date.now()
				var template = `
					<li class="pull-left mr-20 relative">
						<label class="block txt-c fz-20 color-717171" for="img[${pid}]${nid}">
							<i class="fa fa-camera"></i>
						</label>
						<div class="ordercomment_imgs_list_img relative hide">
							<i class="fa fa-times-circle block J_remove_img"></i>
						</div>
	                    <input type="file" name="${$elem.attr('name')}" id="img[${pid}]${nid}" class="invisibility J_imgs absolute" accept="image/jpeg,image/jpg,image/png">
	                </li>
				`
				$elem.parents('.ordercomment_imgs_list').append(template)
				$elem.parents('.ordercomment_imgs_list').find('.J_imgs').off('change', showImg).on('change', showImg)
				$elem.parents('.ordercomment_imgs_list').find('.J_remove_img').off('tap', removeFile).on('tap', removeFile)
			}
			function removeFile () {
				var pid = $(this).parents('.ordercomment_container').data('id')
				var id = $(this).parents('li').find('input').attr('id')
				if ($(this).parents('.ordercomment_imgs_list').find('img').length == 4) {
					var name = $(this).parents('li').find('input').attr('name')
					$(this).parent().find('img').remove()
					$(this).parent().addClass('hide').siblings('label').removeClass('hide')
					$(this).parents('li').find('input').remove()
					$(this).parents('li').append(`<input type="file" name="${name}" id="${id}" class="invisibility J_imgs absolute" accept="image/jpeg,image/jpg,image/png"">`)
					var cl = $(this).parents('li').clone()
					$(this).parents('.ordercomment_imgs_list').append(cl)
					$('.J_imgs').off('change', showImg).on('change', showImg)
				}
				$(this).parents('li').remove()
			}
			// // 图片变化
			// $('.J_imgs').on('change', showImg)
			// // 删除图片
			// $('.J_remove_img').on('tap', removeFile)
			
			ajax('get', '/home/order/comment/product/' + "{{$id}}").then(function (res) {
				var data = res
				if (data.length) {
					addProduct (data)
					// 图片变化
					$('.J_imgs').on('change', showImg)
					// 删除图片
					$('.J_remove_img').on('tap', removeFile)
					$('.J_grade').on('tap', grade)
				} else {
					fxPrompt.message('获取数据失败')
				}
			})

			function addProduct (data) {
				var template = ''
				data.forEach(function (v){
					var order_price = v.order_price * v.amount
					var price = v.price * v.amount
					template += `
					<div class="ordercomment_container mb-10" data-id="${v.id}">
						<div class="ordercomment_warpper">
							<div class="warpper_img pull-left mr-20">
								<img class="w-100" src="http://${window.location.host}/${v.thumb}">
							</div>
							<div class="warpper_detail pull-left mr-20">
								<h5 class="chayefont mb-10">${v.name}</h5>
								<p class="color-8C8C8C">${v.desc}</p>
							</div>
							<div class="warpper_price pull-left txt-r">
								<span class="block price">&yen;${order_price}</span>
								<del class="block price_raw color-8C8C8C">&yen;${price}</del>
								<span class="block times color-8C8C8C">&times;${v.amount}</span>
							</div>
						</div>
						<div class="ordercomment_comment w-100 mt-20">
							<textarea placeholder="评价" id ="content${v.id}" class="h-100 w-100"></textarea>
						</div>
						<div class="ordercomment_score w-100 fz-16 color-8C8C8C mt-20 clearfix">
							<span class="pull-left">满意度：</span>
							<div class="ordercomment_score_star pull-left">
								<i class="fa fa-star-o J_grade" data-grade="1"></i>
								<i class="fa fa-star-o J_grade" data-grade="2"></i>
								<i class="fa fa-star-o J_grade" data-grade="3"></i>
								<i class="fa fa-star-o J_grade" data-grade="4"></i>
								<i class="fa fa-star-o J_grade" data-grade="5"></i>
							</div>
							<input type="hidden" id="grade${v.id}" value="0">
						</div>
						<div class="ordercomment_imgs mt-20">
							<span>晒图：</span>
							<ul class="ordercomment_imgs_list mt-20 clearfix">
								<li class="pull-left mr-20 relative">
									<label class="block txt-c fz-20 color-717171" for="img[${v.id}]${Date.now()}">
										<i class="fa fa-camera"></i>
									</label>
									<div class="ordercomment_imgs_list_img relative hide">
										<i class="fa fa-times-circle block J_remove_img"></i>
									</div>
									<input type="file" name="imgs${v.id}[]" id="img[${v.id}]${Date.now()}" class="invisibility J_imgs absolute" accept="image/jpeg,image/jpg,image/png">
								</li>
							</ul>
						</div>
					</div>`
				})
				$(".ordercomment_lists").append(template)
			}

			// 评分
			function grade () {
				var id = $(this).parents('.ordercomment_container').data('id')
				var grade = parseInt($(this).data('grade'))
				$(this).parents('.ordercomment_score_star').find('i').each(function (idx, elem) {
					if (idx <= (grade - 1)) {
						$(this).addClass('active fa-star').removeClass('fa-star-o')
					} else {
						$(this).removeClass('active fa-star').addClass('fa-star-o')
					}
				})
				$('#grade' + id).val(grade)
			}

			// 提交
			$('.J_comment').on('tap', function () {
				// ajax提交
				// if ($.trim($('#content').val()) == '' || $.trim($('#content').val()).length < 5) {
				// 	fxPrompt.message('评价至少要5个字')
				// 	return
				// }
				// if ($('#grade').val() <= 0) {
				// 	fxPrompt.message('请选择您的满意度')
				// 	return
				// }

				var params = {}, temp = true,
					hasImg = false, cacheFiles = {} // 判断是否有文件 缓存文件进行判断是否压缩
				$('.ordercomment_container').each(function () {
					var id = $(this).data('id')
					if ($.trim($('#content' + id).val()) == '' || $.trim($('#content' + id).val()).length < 5) {
						fxPrompt.message('评价至少要5个字')
						temp = false
						return
					}
					if ($('#grade' + id).val() <= 0) {
						fxPrompt.message('请选择您的满意度')
						temp = false
						return
					}
					var files = []
					$(this).find('.J_imgs').each(function () {
						if (this.files[0]) {
							hasImg = true
							files.push(this.files[0])
						}
					})
					params['content' + id] = $('#content' + id).val()
					params['grade' + id] = $('#grade' + id).val()
					// params['imgs' + id + '[]'] = files
					cacheFiles[id] = files
				})
				if (!temp) return
				if (hasImg) {
					console.dir(cacheFiles)
					var all = []
					for (var i in cacheFiles) {
						all.push(new Promise(function (reso) {
							var pms = []
							pms.idx = i
							cacheFiles[i].forEach(function (v) {
								pms.push(new Promise(function (resolve) {
									if (v.size / 1024 > 200) {
										resizeImg(v)
										.then(function (blob) {
											resolve({
												id: pms.idx,
												b: blob
											})
										})
									} else {
										resolve({
											id: pms.idx,
											b: v
										})
									}
								}))
							})
							Promise.all(pms)
							.then(function (images) {
								reso(images)
							})
						}))
					}
					Promise.all(all)
					.then(function (all) {
						all.forEach(function (v) {
							var barr = []
							v.forEach(function (vl) {
								barr.push(vl.b)
								params['imgs' + vl.id + '[]'] = barr
							})
						})
						submitAjax(params)
					})
				} else {
					submitAjax(params)
				}
			})

			function submitAjax (params) {
				fxPrompt.loading('提交中')
				ajax('post', '/home/order/comment/store/'+"{{$id}}", params, false, true)
				.then(function (res) {
					if (res) {
						// fxPrompt.message('评论成功！', 'history')
						fxPrompt.message('评论成功！', 'http://'+window.location.host+'/home/order/list')
					} else {
						fxPrompt.message('服务器繁忙,请稍后再试！')
					}
				})
			}
		})
	</script>
@endsection

@section('content')
	<div class="ordercomment">
		<div class="ordercomment_header w-100">
			<div class="ordercomment_header_left white txt-c pull-left header_back" onclick="javascript:history.go(-1);">返回</div>
			<a href="javascript:;" class="ordercomment_header_right white txt-c pull-right chayefont J_comment">发表</a>
			<div class='ordercomment_header_center txt-c w-100 chayefont'><h2 class="white">发表评价</h2></div>
		</div>
		<div class="ordercomment_lists">

		</div>
		<!-- <div class="ordercomment_comment mt-20">
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
		</div> -->
	</div>
@endsection
