@extends('layouts.app')

@section('title') 确认订单 @endsection

@section('css')
@endsection

@section('script')
    @parent
    <script>

		var delivery_price = {{$lists->max('delivery_price')}}
		var grade_price = 0;
    	$(function () {

    		// 显示选取配送方式弹窗
    		$('.J_show_type').on('click tap', function () {
    			$('.confirm_type').addClass('top-0')
    		})
    		// 隐藏选取配送方式弹窗
    		$('.J_hide_type').on('click tap', function () {
    			$('.confirm_type').removeClass('top-0')
    		})
    		// 选取配送方式
    		$('.J_choose_type').on('click tap', function () {
    			var v = $(this).data('delivery')
    			if (v == 'point') {
    				$(".price-change").html('&yen; 0.00');
    				delivery_price = 0;
    			} else {
    				$(".price-change").html('&yen; ' + delivery_price);
    				delivery_price = {{$lists->max('delivery_price')}};
    			}
    			countPrice();
    			$(this).parents('.confirm_type_container').find('i').removeClass('active')
    			$(this).find('i').addClass('active')
    			$('input[name="delivery"]').val(v)
    			$('#delivery').text($(this).find('span').text())
    			$('.confirm_address').each(function () {
    				$(this).addClass('hide')
    				if ($(this).hasClass(v)) {
    					$(this).removeClass('hide')
    				}
    			})
    		})

    		// 跳转到地址页
    		$('.J_jump_address').on('click tap', function () {
    			if (sessionStorage) {
    				sessionStorage.setItem('chaye', window.location.href)
    			}
    			window.location.href = 'http://' + window.location.host + '/home/address'
    		})

    		// 重置返回按钮
    		$('.J_header_back').off('click tap').on('click tap', function () {
				history.go(-1)
			})

    	});

    	addressData();
		siteData();
		countPrice();
    	//获取默认地址
    	function addressData() {
	    	ajax('get', '/home/address/state').then(function (resolve) {
				if (resolve) {
					$(".address-name").text(resolve['name']);	
					$(".address-phone").text(resolve['phone']);
					if (resolve['city'] == resolve['area']) {
						$(".address-detail").text(resolve['province'] + resolve['city'] + resolve['detail']);
					} else {
						$(".address-detail").text(resolve['province'] + resolve['city'] + resolve['area'] + resolve['detail']);
					}
				} else {
					$(".address-name").text('创建新地址');
				}
			});
    	}

    	//获取站点
    	function siteData() {
	    	ajax('get', '/home/site/default').then(function (resolve) {
				if (resolve) {
					$(".site-name").text(resolve['name']);
				} else {
					
				}
			});
    	}

    	//计算总金额
    	function countPrice() {
    		var product_price = $(".product-count").attr('count');
    		var count = parseFloat(product_price) + parseFloat(delivery_price) - parseFloat(grade_price);
    		$(".all-count").html('&yen;'+count.toFixed(2));
    	}

    	//提交订单
    	$('.confirm_bottom_submit').click(function(){
    		prompt.message('提交订单！')
    	});

    	//积分抵扣金额
    	$("#gradeChange").on('change', function(){
    		var grade = $(".user-grade").attr('grade');
    		grade_price = 0;
    		if ($(this).is(':checked')) {
    			grade_price = grade/100;
    			$('.confirm_grade').addClass('active')
    		} else {
    			$('.confirm_grade').removeClass('active')
    		}
    		countPrice();
    	});
    </script>
@endsection

@section('content')
	@include("layouts.header-info")
	
	@include("layouts.backIndex")

	<div class="confirm">
		<div class="confirm_address mb-20 express">
			<a href="javascript:;" class="clearfix J_jump_address">
				<i class="fa fa-map-marker pull-left"></i>
				<div class="confirm_address_info pull-left">
					<p class="clearfix">
						<span class="pull-left chayefont fz-20 address-name"> </span> <!-- 联系人 -->
						<span class="pull-right gray fz-16 address-phone"> </span><!--  手机 -->
					</p>
					<p class="gray fz-14 address-detail"> </p><!-- 地址 -->
				</div>
				<i class="fa fa-angle-right pull-right txt-r"></i>
			</a>
		</div>
		<div class="confirm_address mb-20 point hide">
			<a href="{{url('/home/order/site')}}" class="clearfix">
				<i class="fa fa-map-marker pull-left"></i>
				<div class="confirm_address_info pull-left">
					<p>当前自提点</p>
					<p class="gray fz-16 site-name"></p>
				</div>
				<i class="fa fa-angle-right pull-right txt-r"></i>
			</a>
		</div>
		<div class="confirm_container">
		@foreach($lists as $list)
			<div class="confirm_warpper clearfix mb-20">
				<div class="confirm_warpper_content_img pull-left mr-20">
					<img src="{{ url('') }}/{{$list->thumb}}">
				</div>
				<div class="confirm_warpper_content_info pull-right">
					<h5 class="chayefont mb-10">{{$list->name}}</h5>
					<p class="desc">{{$list->desc}}</p>
					<div class="confirm_warpper_content_info_bottom">
						<span class="pull-left price">&yen; 
						@if ($list->activity_price)
							{{sprintf('%.2f',$list->activity_price * $list->amount)}}
						@else
							{{sprintf('%.2f',$list->amount * $list->price)}}
						@endif
						</span>
						<span class="pull-right sell">&times;{{$list->amount}}</span>
					</div>
				</div>
			</div>
		@endforeach
			<div class="confirm_container_sum">
				<div class="confirm_container_sum_row">
					<a href="javascript:;" class="clearfix J_show_type">
						<span class="pull-left chayefont fz-18">配送方式</span>
						<span class="pull-right gray fz-14"><s id="delivery">快递</s><i class="fa fa-angle-right ml-10"></i></span>
						<input type="hidden" value="express" name="delivery">
					</a>
				</div>
				<div class="confirm_container_sum_row">
					<span class="pull-left chayefont fz-18">运费</span>
					<span class="pull-right price fz-14 price-change" >&yen; {{sprintf('%.2f',$lists->max('delivery_price'))}}</span>
				</div>

				<div class="confirm_container_sum_row">
					<span class="pull-left chayefont fz-18">商品总额</span>
					<span class="pull-right price fz-14 product-count" count="{{$count}}">&yen; {{sprintf('%.2f',$count)}} </span>
				</div>
				
				<div class="confirm_container_sum_row">
					<span class="pull-left chayefont fz-18">积分抵扣</span>
					<span class="pull-right price fz-14 user-grade" grade="{{Auth::user()->grade}}">
						<input type="checkbox" id="gradeChange" class="invisibility" @if (!$grade) disabled="true"@endif>
						@if ($grade) {{Auth::user()->grade}}分 @else 不可用 @endif
					</span>
					<label for="gradeChange" class="confirm_grade pull-right"></label>
				</div>
				
				<div class="confirm_container_sum_row">
					<span class="pull-left chayefont fz-18">优惠券</span>
					<span class="pull-right gray fz-14">
						@if(count($cheaps))
							<s id="roll">请选择</s><i class="fa fa-angle-right ml-10"></i>
						@else 
							<s>无优惠券</s>
						@endif
					</span>
				</div>
				
				<div class="confirm_container_sum_row">
					<span class="pull-left chayefont fz-18">买家留言</span>
					<span class="pull-right gray fz-14">选填</span>
				</div>

				<textarea placeholder="请留言"></textarea>
			</div>
		</div>
		<div class="confirm_bottom">
			<div class="confirm_bottom_sum pull-left txt-l">
				合计总金额：<span class="price all-count">&yen;0.00</span>
			</div>
			<div class="confirm_bottom_submit pull-left">
				<a href="javascript:;">提交订单</a>
			</div>
		</div>
	</div>
	<div class="confirm_type">
		<div class="confirm_type_container">
			<h5 class="chayefont fz-18">配送方式</h5>
			<div class="confirm_type_row J_choose_type" data-delivery="point">
				<span class="pull-left chayefont fz-16">自取</span>
				<i class="pull-right"></i>
			</div>
			<div class="confirm_type_row J_choose_type" data-delivery="express">
				<span class="pull-left chayefont fz-16">快递</span>
				<i class="pull-right active"></i>
			</div>
			<div class="confirm_type_bottom chayefont fz-18 J_hide_type">关闭</div>
		</div>
	</div>
	<div class="confirm_roll">
		<div class="confirm_roll_container">
			<h5 class="chayefont fz-18">优惠卷</h5>
			<div class="confirm_roll_list">
				@foreach ($cheaps as $va)
				<div class="confirm_roll_row J_choose_roll" data-cut="{{$va->cut}}">
					<span class="pull-left chayefont fz-16">{{$va->name}}</span>
					<i class="pull-right"></i>
				</div>
				@endforeach
			</div>
			<div class="confirm_roll_bottom chayefont fz-18 J_hide_roll">关闭</div>
		</div>
	</div>
@endsection
