@extends('layouts.app')

@section('title') 发表评论 @endsection

@section('css')
@endsection

@section('script')
    @parent
    <script>
    	$(function () {
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
    			var params = {
    				content: $('#content').val(),
    				grade: $('#grade').val()
    			}
    			ajax('post', '/home/order/comment', params, false, true)
    				.then(function (res) {
    					console.log(res)
    				})
    		})
    		// prompt.image()
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
            <div class="ordercomment_warpper">
                <div class="ordercomment_warpper_img pull-left mr-20">
                    <img src="{{url('fx/images/goods_avatar.png')}}">
                </div>
                <div class="ordercomment_warpper_detail pull-left mr-20">
                    <h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
                    <p>新鲜梨酥雪梨发货供货的供货皇冠分隔符梨</p>
                </div>
                <div class="ordercomment_warpper_price pull-left txt-r">
                    <span class="block price">&yen;212.00</span>
                    <del class="block price_raw">&yen;299.00</del>
                    <span class="block times">&times;2</span>
                </div>
            </div>
            <div class="ordercomment_warpper">
                <div class="ordercomment_warpper_img pull-left mr-20">
                    <img src="{{url('fx/images/goods_avatar.png')}}">
                </div>
                <div class="ordercomment_warpper_detail pull-left mr-20">
                    <h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
                    <p>新鲜梨酥雪梨发货供货的供货皇冠分隔符梨</p>
                </div>
                <div class="ordercomment_warpper_price pull-left txt-r">
                    <span class="block price">&yen;212.00</span>
                    <del class="block price_raw">&yen;299.00</del>
                    <span class="block times">&times;2</span>
                </div>
            </div>
            <div class="ordercomment_warpper">
                <div class="ordercomment_warpper_img pull-left mr-20">
                    <img src="{{url('fx/images/goods_avatar.png')}}">
                </div>
                <div class="ordercomment_warpper_detail pull-left mr-20">
                    <h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
                    <p>新鲜梨酥雪梨发货供货的供货皇冠分隔符梨</p>
                </div>
                <div class="ordercomment_warpper_price pull-left txt-r">
                    <span class="block price">&yen;212.00</span>
                    <del class="block price_raw">&yen;299.00</del>
                    <span class="block times">&times;2</span>
                </div>
            </div>
		</div>
		<div class="ordercomment_comment mt-20">
			<textarea placeholder="评价" id ="content"></textarea>
		</div>
		<div class="ordercomment_score mt-20 clearfix">
			<span class="pull-left">评价：</span>
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
				<li class="pull-left mr-20">
					<label for="img1">
						<i class="fa fa-camera"></i>
					</label>
					<div class="ordercomment_imgs_list_img hide">
						<i class="fa fa-times-circle"></i>
						<img src="{{url('/fx/images/usercenter_avatar.png')}}" alt="">
					</div>
				</li>
			</ul>
		</div>
		<input type="file" name="imgs[]" id="img1" class="invisibility" accept="image/jpeg,image/jpg,image/png" capture="camera">
	</div>
@endsection
