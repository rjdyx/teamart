@extends('layouts.app')

@section('title') 站点位置 @endsection

@section('css')
@endsection

@section('script')
    @parent
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak={{env('ORDER_SITE')}}"></script>
    <script>
    	$(function () {
    		function renderMap (points) {
    			function getaddress (map, BMap, point) {
    				var myGeo = new BMap.Geocoder();
    				new Promise(function (resolve) {
						myGeo.getLocation(point, function(rs){
							var addComp = rs.addressComponents
							var address = `${addComp.province}${addComp.city}${addComp.district}${addComp.street}${addComp.streetNumber}`
							$('#address').text(address)
							resolve(address)
						})
					}).then(function (resolve) {
						var geolocation = new BMap.Geolocation();
						geolocation.getCurrentPosition(function(r){
							if(this.getStatus() == BMAP_STATUS_SUCCESS){
								var npoint = new BMap.Point(r.point.lng, r.point.lat)
								var distance = map.getDistance(point,npoint)
								if (distance < 1000) {
									$('#distance').text(distance.toFixed(2) + '米')
								} else {
									$('#distance').text((distance/1000).toFixed(2) + '公里')
								}
							}
							else {
								alert('failed'+this.getStatus());
							}        
						},{enableHighAccuracy: true})
					})
    			}
    			// initBMap().then(function(BMap) {
				var map = new BMap.Map("allmap");
				if (points.length > 0) {
					map.centerAndZoom(new BMap.Point(points[0].lng, points[0].lat), 15)
					getaddress(map, BMap, new BMap.Point(points[0].lng, points[0].lat))
					points.forEach(function (v) {
						var point = new BMap.Point(v.lng, v.lat)
						var marker = new BMap.Marker(point)
						map.addOverlay(marker)
					})
				} else {
					map.centerAndZoom('广州', 11);
				}
				map.setMinZoom(6)
				map.setMaxZoom(19)
				// 创建地址解析器实例

				// 添加带有定位的导航控件
				var navigationControl = new BMap.NavigationControl({
					// 靠左上角位置
					anchor: BMAP_ANCHOR_TOP_LEFT,
					// LARGE类型
					type: BMAP_NAVIGATION_CONTROL_LARGE,
				});
				map.addControl(navigationControl);

				// 选择自提点
				$('.J_choose_site').on('tap', function () {
	    			$(this).addClass('active').siblings().removeClass('active')
	    			var point = new BMap.Point($(this).data('lng'), $(this).data('lat'))
	    			map.centerAndZoom(point, 15)
	    			getaddress(map, BMap, point)
	    		})
	    		// })
    		}
    		
			
    		getSiteList()

    		// 获取自提点列表
    		function getSiteList () {
    			ajax('get', '/home/site/data')
    				.then(function (res) {
    					var template = ''
    					if (res.data.length) {
    						res.data.forEach(function (v) {
    							template += `
    								<div class="ordersite_warp color-717171 relative clearfix J_choose_site" data-lat="${v.latitude}" data-lng="${v.longitude}">
										<i class="fa fa-map-marker block txt-c fz-24"></i>
										<div class="ordersite_warp_info pull-right">
											<h1 class="mb-10 color-3B3B3B">${v.name}</h1>
											<p class="clearfix">
												<span class="pull-left">店长：${v.user}</span>
												<span class="pull-right">联系电话：<a href="tel:${v.phone}">${v.phone}</a></span>
											</p>
										</div>
									</div>
    							`
    						})
    						$('.ordersite_message').removeClass('hide')
    					} else {
    						template += '<div class="txt-c mt-20 fz-20">暂无自提点</div>'
    					}
    					$('.ordersite_list').html(template)
    					var points = []
    					$('.J_choose_site').each(function (idx, elem) {
    						if (idx == 0) {
    							$(this).addClass('active')
    						}
    						points.push({
    							lng: $(this).data('lng'),
    							lat: $(this).data('lat')
    						})
    					})

    					renderMap(points)

    				})
    		}
    	})
    </script>
@endsection

@section('content')

    @include("layouts.header-info")
	<div class="container ordersite">
		<div class="ordersite_map w-100 txt-c" id="allmap">加载中</div>
		<div class="ordersite_message w-100 txt-c hide">
			<p>地址：<span id="address"></span></p>
			<p>距离您的位置约<span id="distance"></span></p>
		</div>
		<div class="ordersite_list w-100">
			<!-- <div class="txt-c mt-20 fz-20">暂无自提点</div> -->
			<!-- <div class="ordersite_warp clearfix active J_choose_site">
				<i class="fa fa-map-marker"></i>
				<div class="ordersite_warp_info pull-right">
					<h1 class="mb-10">xxxxx自提点</h1>
					<p class="clearfix">
						<span class="pull-left">店长：zxx</span>
						<span class="pull-right">联系电话：<a href="tel:13912345678">13912345678</a></span>
					</p>
				</div>
			</div>
			<div class="ordersite_warp clearfix J_choose_site">
				<i class="fa fa-map-marker"></i>
				<div class="ordersite_warp_info pull-right">
					<h1 class="mb-10">xxxxx自提点</h1>
					<p>广州市天河区华南理工大学北区国家科技园553514号</p>
				</div>
			</div>
			 -->
		</div>
	</div>
@endsection