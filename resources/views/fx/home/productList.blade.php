@extends('layouts.app')

@section('title') 商品搜索 @endsection

@section('css')
@endsection

@section('script')
	@parent
	<script type="text/javascript" src="{{ url('fx/js/dropload.min.js') }}"></script>
	<script>
		//定义全局对象
		var params = {type:'', up:'', name:'', brand:'', category:'', min:'', max:'',page:1};
		params['name'] = "{{isset($_GET['name'])?$_GET['name']:''}}";
		params['category'] = "{{isset($_GET['category'])?$_GET['category']:''}}";
		$(function () {
			var page = 0;//分页
			var brands = categorys = {};
			var bstate = cstate = false;

			// 返回顶部
			backTop('product_container')
			// 显示筛选
			$('.J_show_filter').on('click', function () {
				getBrandOrCategory();
				$('.filter').addClass('left-0')
				$("input[name='min_price']").val(params['min']);
				$("input[name='max_price']").val(params['max']);
			})

			// 隐藏筛选
			$('.J_hide_filter').on('click', function () {
				$('.filter').removeClass('left-0');
			});

			var dropload = $('.product_container').dropload({
				scrollArea : $('.product_container'),
				domUp : {
					domClass   : 'dropload-up',
					domRefresh : '<div class="dropload-refresh">↓下拉刷新</div>',
					domUpdate  : '<div class="dropload-update">↑释放更新</div>',
					domLoad    : '<div class="dropload-load"><span class="loading"></span>加载中...</div>'
				},
				domDown : {
					domClass   : 'dropload-down',
					domRefresh : '<div class="dropload-refresh">↑上拉加载更多</div>',
					domLoad    : '<div class="dropload-load"><span class="loading"></span>加载中...</div>',
					domNoData  : '<div class="dropload-noData">没有更多数据了</div>'
				},
				loadUpFn : function(me){
					getListData(me,'up');
				},
				loadDownFn : function(me){
					getListData(me,'down');
				},
				threshold : 50
			});
			
			function getLists (success, me) {
				var url = 'http://'+window.location.host + '/home/product/list/data';
				ajax('get', url, params)
				.then(function (res) {
					var result = ''
					if (res.data.length) {
						res.data.forEach(function (v) {
							result += `
								<div class="product_warpper pull-left">
									<a href='http://${window.location.host}/home/product/detail/${v.id}'>
										<img src='http://${window.location.host}/${v.img}'>
										<h1 class="mt-20 chayefont">${v.name}</h1>
										<p class="mt-10 mb-10 desc">${v.desc}</p>
										<p class="clearfix">
											<span class="pull-left price">&yen;${v.price}</span>
											<span class="pull-right sell">销量：<i>${v.sell_amount}</i></span>
										</p>
									</a>
								</div>
							`
						})
					} else {
						if (me) {
							me.lock();
							// 无数据
							me.noData();
						}
					}
					success(result)
				})
			}

			//获取列表数据
			function getListData(me,type) {
				if (type=='down')
				{
					page++;
					params['page'] = page;
				} else {
					params['page'] = page = 1
				}
				getLists(function (result) {
					if (type == 'up') {
						$('.product_list').html(result);// 插入数据到页面，放到最后面
					} else {
						$('.product_list').append(result);// 插入数据到页面，放到最后面
					}
					me.resetload();// 每次数据插入，必须重置
					if (type == 'up') {
						// 解锁loadDownFn里锁定的情况
						me.unlock();
						me.noData(false);
					}
				}, me)
			}

			//获取所有分类、品牌
			function getBrandOrCategory() {
				var url = 'http://'+window.location.host + '/home/product/';
				axios.get(url + 'category').then(function (res) {
					categorys = res.data
					addCategoryResult(false);
				}).catch(function (err) {
					console.log(err)
				});
				axios.get(url + 'brand',{}).then(function (res) {
					brands = res.data
					addBrandResult(false);
				}).catch(function (err) {
					console.log(err)
				});
			}

			//添加分类节点
			function addCategoryResult(state){
				var result = '';
				var len = categorys.length
				var u = 0;
				if(len > 0){
					if (len>6 && !state) {len = 6;};
					if (state) u = 6;
					for(var i=u; i<len; i++){
						result += '<li  sid='+ categorys[i]['id'];
						if (categorys[i]['id'] == params['category']) {
							result += ' class="active" ';
						}
						result += ' state=0>'+'<a href="javascript:;">'+categorys[i]['name']+'</a>'+'</li>';
					}
				}
				if (state) {
					$('.filter_category_list').append(result);
				} else {
					$('.filter_category_list').html(result);
				}
			}

			//添加品牌节点
			function addBrandResult(state){
				var result = '';
				var len = brands.length;
				var u = 0;
				if(len > 0){
					if (len>6 && !state) {len = 6;};
					if (state) u = 6;
					for(var i=u; i<len; i++){
						result += '<li sid='+ brands[i]['id'];
						if ($.inArray(brands[i]['id'].toString(), params['brand']) != -1) {
							result += ' class="active" ';
						}
						result += ' state=0 >'+'<a href="javascript:;">'+brands[i]['name']+'</a>'+'</li>';
					}
				}
				if (state) {
					$('.filter_brand_list').append(result);
				} else {
					$('.filter_brand_list').html(result);
				}
			}

			//分类展开全部
			$(".category-show").click(function(){
				if (cstate) {
					$(this).children('i').removeClass('active');
					cstate = false;
					$('.filter_category_list li').each(function(i){
						if(i > 5){ $(this).remove(); }
					});
				} else {
					$(this).children('i').addClass('active')
					cstate = true;
					addCategoryResult(true);
				}
			});

			//品牌展开全部
			$(".brand-show").click(function(){
				if (bstate) {
					$(this).children('i').removeClass('active');
					bstate = false;
					$('.filter_brand_list li').each(function(i){
						if(i > 5){ $(this).remove(); }
					});
				} else {
					$(this).children('i').addClass('active')
					bstate = true;
					addBrandResult(true);
				}
			});

			//点击排序属性
			$(".order").click(function(){
				var fx = $(this).attr('order');
				var a = 'up'; var b = 'down'; var order = 'desc';
				$(".order").attr('order','up');
				$(".order").children('i').removeClass('fa-caret-up');
				$(".order").children('i').addClass('fa-caret-down');
				if (fx == 'up') {
					order = 'asc';
					a = 'down';b = 'up';
					$(this).attr('order','down');
				}
				$(this).children('i').removeClass('fa-caret-'+a);
				$(this).children('i').addClass('fa-caret-'+b);

				//获取参数 异步搜索
				params['type'] = $(this).attr('type');
				params['up'] = order;
				searchListData();
			});

			//筛选提交
			$('#opts_submit').click(function(){
				//设置分类、品牌、价格区间
				var cid = $(".filter_category_list li[class='active']").attr('sid');
				var bids = [];
				$('.filter_brand_list li[class="active"]').each(function(i){
					bids[i] = $(this).attr('sid');
				});
				var min = $("input[name='min_price']").val();
				var max = $("input[name='max_price']").val();
				params['category'] = cid;
				params['brand'] = bids;
				params['min'] = min;
				params['max'] = max;
				$('.filter').removeClass('left-0');
				searchListData();
			});

			//重置方法
			function reset(){
				category = brands = {};
				bstate = cstate = false;
				$("input[name='min_price']").val('');
				$("input[name='max_price']").val('');
				$(".brand-show").children('i').removeClass('active');
				$(".category-show").children('i').removeClass('active');
				$(".filter_category_list li").removeClass('active');
				$(".filter_brand_list li").removeClass('active');
			}

			//重置按钮
			$("#reset").click(function(){
				reset();
			});

			//条件搜索
			function searchListData(){
				params['page'] = page = 1
				getLists(function (result) {
					$('.product_list').html(result);
					$('.product_container').scrollTop(0)
					dropload.resetload()
				})
			}

			//单个分类点击事件
			$('.filter_category_list').on('click','li', function () {
				$(".filter_category_list li").removeClass('active');
				$(this).addClass('active');
			});

			//单个品牌点击事件
			$('.filter_brand_list').on('click','li', function () {
				var state = $(this).attr('state');
				if (state>0) {
					$(this).removeClass('active');
					$(this).attr('state',0);
				} else {
					$(this).addClass('active');
					$(this).attr('state',1);
				}
			});
		});	

	</script>
@endsection

@section('content')
	@include("layouts.header")
	<div class="filter">
		<div class="filter_bg J_hide_filter"></div>
		<div class="filter_container">
			<div class="filter_price mb-20">
				<span>价格区间</span>
				<div class="filter_price_box mt-20 clearfix">
					<input type="number" name="min_price" class="pull-left" placeholder="最低价">
					<i class="fa fa-minus pull-left"></i>
					<input type="number" name="max_price" class="pull-left" placeholder="最高价">
				</div>
			</div>
			<div class="filter_category mb-20">
				<div class="filter_category_top">
					<span class="pull-left">全部分类</span>
					<a href="javascript:;" class="pull-right category-show">
						全部
						<i class="fa fa-angle-right"></i>
					</a>
				</div>
				<ul class="filter_category_list clearfix">

				</ul>
			</div>
			<div class="filter_brand">
				<div class="filter_brand_top">
					<span class="pull-left">品牌</span>
					<a href="javascript:;" class="pull-right brand-show">
						全部
						<i class="fa fa-angle-right"></i>
					</a>
				</div>
				<ul class="filter_brand_list clearfix">

				</ul>
			</div>
			<div class="filter_opts">
				<span class="filter_opts_btn pull-left reset" id="reset">重置</span>
				<span class="filter_opts_btn pull-left del" id="opts_submit">确定</span>
			</div>
		</div>
	</div>
	<div class="container product">
		<ul class="product_nav">
			<li class="order" order="up" type="all">
				综合
				<i class="fa fa-caret-down"></i>
			</li>
			<li class="order" order="up" type="sell">
				销量
				<i class="fa fa-caret-down"></i>
			</li>
			<li class="order" order="up" type="price">
				价格
				<i class="fa fa-caret-down"></i>
			</li>
			<li class="J_show_filter">
				筛选
				<i class="fa fa-filter"></i>
			</li>
		</ul>
		<div class="product_container" id="product_container">
			<div class="product_list clearfix">
				<!-- 数据放置处 -->
			</div>
		</div>
	</div>
	@include("layouts.backTop")

	@include("layouts.footer")
@endsection
