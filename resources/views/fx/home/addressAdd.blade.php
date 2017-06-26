@extends('layouts.app')

@section('title') 地址管理 @endsection

@section('css')
@endsection

@section('script')
    @parent
    {{-- <script src="{{url('fx/js/dialog.js')}}"></script>
    <script src="{{url('fx/js/mobile-select-area.js')}}"></script>
    <script>
    	console.log($.confirm)
    	var data = {
	        "data": [{
	            "id": 1,
	            "name": "浙江省",
	            "child": [{
	                "id": "1",
	                "name": "杭州市",
	                "child": [{
	                    "id": 1,
	                    "name": "滨江区"
	                }]
	            }]
	        }, {
	            "id": 2,
	            "name": "江苏省",
	            "child": [{
	                "id": "1",
	                "name": "南京",
	                "child": [{
	                    "id": 1,
	                    "name": "解放区"
	                }]
	            }]
	        }, {
	            "id": 3,
	            "name": "湖北省"
	        }]
	    }
		var selectArea = new MobileSelectArea()
		selectArea.init({
			trigger: $('.J_msa'),
			value: $('.J_msa_data').val(),
			data: data
		})
    </script> --}}
@endsection

@section('content')
	@include("layouts.header-info")
	<div class="addressadd">
<<<<<<< HEAD
		<form action="#" name="addressform">
			<div class="addressadd_item chayefont">
				<label for="name">收货人</label>
				<input type="text" name="name" id="name" class="chayefont" autocomplete="off" placeholder="请输入收货人名称">
			</div>
			<div class="addressadd_item chayefont">
				<label for="phone">联系电话</label>
				<input type="tel" name="phone" id="phone" class="chayefont" autocomplete="off" placeholder="请输入收货人名称">
			</div>
			<div class="addressadd_item chayefont">
				<label for="region">所在地区</label>
				<input type="hidden" name="province" id="province" value="">
				<input type="hidden" name="city" id="city" value="">
				<input type="hidden" name="area" id="area" value="">
				<input type="hidden" value="" class="J_msa_data">
				<div class="pull-right addressadd_selection J_msa">请选择<i class="fa fa-angle-right"></i></div>
			</div>
			<div class="addressadd_item chayefont">
				<label for="code">邮编</label>
				<input type="number" name="code" id="code" class="chayefont" placeholder="请输入邮编">
			</div>
			<div class="addressadd_item">
				<textarea name="detail" placeholder="请填写详细地址，不少于5个字"></textarea>
			</div>
			<div class="addressadd_item mt-20">
				<label for="state" class="block">
					默认地址
					<i class="pull-right address_default"></i>
				</label>
				<input type="hidden" name="state" id="state" value="0">
			</div>
		</form>
		<div class="chayefont address_add">添加新地址</div>
	</div>
=======
		
	</div>
	<div class="addAddress_container">
		<ul>
			<li class="item_list">
				<span class="item_list_title">收货人</span>
				<div class="item_input_container"><input class="item_input" type="text" name="" placeholder="隔壁老王"></div>
			</li>
			<li class="item_list">
				<span class="item_list_title">联系电话</span>
				<div class="item_input_container"><input class="item_input" type="text" name="" placeholder="13560449011"></div>
			</li>
			<li class="item_list">
				<span class="item_list_title">所在地区</span>
				<div class="item_input_container">
					<select>
						<option>请选择&gt;</option>
						<option>广东</option>
					</select>
				</div>
			</li>
			<li class="item_list">
				<span class="item_list_title">街道</span>
				<div class="item_input_container">请选择&gt;</div>
			</li>
		</ul>
		<textarea class="addressDetail" placeholder="请填写详细地址，不少于5个字"></textarea>
		<div class="defaultAddress">
			<span>默认地址</span>
			<div class="img_container"><img class="defaultAddress_img" src="{{ url('fx/img/setDefault.png') }}"></div>
		</div>
	</div>

	<!-- 底部 -->
	<div class="bottom2">保存新地址</div>
>>>>>>> dev-ynf
@endsection
