<!DOCTYPE html>
<html lang="en">
<head>
	<title>确认订单</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no,minimal-ui">
	<meta name="format-detection" content="telephone=no">
	<link rel="stylesheet" type="text/css" href="../css/reset.css">
	<link rel="stylesheet" type="text/css" href="../css/confirmOrder.css">
</head>
<body>
	<!-- 头部 -->
	<div class="header">
		<div class='condition'></div>
		<div class='header_turnBack' onclick="javascript:history.go(-1);">返回</div>
			<div class='msg'>
				<div class='msg_container'>
					<img src='../img/msg_tips.png' class='msg_tips'>
						<div class='tips_count'>4</div>
						<div class='msg_content'>消息</div>
					</div>
				</div>
		<div class='header_title'>确认订单</div>
	</div>
	<!-- 我的收藏列表 -->
	<div class="container">
		<div class="products">
			<ul>
				<li class="location">
					<div class="location_nav">
						<span class="location_nav_name">隔壁老王</span>
						<span class="location_nav_tel">13560449011</span>
					</div>
					<div class="location_details">
						<div class="location_img_nav">
							<img src="../img/location.png">
						</div>
						<span class="location_font">广东省广州市天河区五山街道华南理工大学国家大学科技园2号楼204</span>
						<img class="arrow" src="../img/right_arrow.png">
					</div>
				</li>
				<li class="products_list">
					<div class="products_nav">
						<div class="products_nav_left">
							<img class="products_nav_img" src="../img/choose.png">
							<img class="goods_nav_img" src="../img/home_active.png">
							<span class="products_nav_font">绿茶宝塔镇河妖</span>
						</div>
						<div class="products_nav_right">
							<span class="products_nav_font">编辑</span>
						</div>
					</div>
					<div class="products_details">
						<div class="products_details_left">
							<div class="products_details_img">
								<img src="../img/shop11.png">
							</div>
						</div>
						<div class="products_details_right">
							<h3 class="products_details_name">菲律宾进口香蕉</h3>
							<p class="products_details_description">新鲜梨树雪梨发货供货的供货皇冠分隔符梨</p>
							<div class="p">
								<p class="prices">￥212.00</p>
								<p class="x">X</p>
								<p class="num">1</p>
							</div>
						</div>
					</div>
				</li>
			</ul>
			<ul class="descript">
				<li class="d">
					<span class="d_font">配送方式</span>
					<div class="way">
						<span class="way_details" id="chooseWay">快递</span>
						<img class="way_arrow" src="../img/right_arrow.png">
					</div>
				</li>
				<li class="d">
					<span class="d_font">运费</span>
					<div class="tip">
						<span class="t">¥</span>
						<span class="t_money">0.00</span>
					</div>
				</li>
				<li class="d">
					<span class="d_font">商品总额</span>
					<div class="sum">
						<span class="t">¥</span>
						<span class="t_money">212.00</span>
					</div>
				</li>
				<li class="d">
					<span class="d_font">买家留言</span>
					<input class="statement" placeholder="选填:对本次交易的说明(建议填写)">
				</li>
			</ul>
		</div>
	</div>
	<!-- 底部 -->
	<div class="bottom">
		<div class="bottom_left">
			<span class="bottom_left_sum">合计总金额:</span>
			<span class="t_all">¥</span>
			<span class="all_money">212.00</span>
		</div>
		<div class="bottom_right">
			<p class="submitOrder">提交订单</p>
		</div>
	</div>
	<!-- 遮罩层 -->
	<div class="bg">
		<div class="sendWay">
			<div class="sendWay_head">
				<p class="sendWay_headFont sendWay_font">配送方式</p>
			</div>
			<ul>
				<li class="sendWayDetails">
					<p class="sendWay_font">自取</p>
					<label class="sendWay_pic">
						<img src="../img/DefaultAddress.png">
					</label>
				</li>
				<li class="sendWayDetails">
					<p class="sendWay_font">快递</p>
					<label class="sendWay_pic">
						<img src="../img/setDefault.png">
					</label>
				</li>
			</ul>
		</div>
		<div class="quit">
			<p class="quit_font">关闭</p>
		</div>
	</div>
	<script type="text/javascript" src="../js/zepto.min.js"></script>
	<script type="text/javascript" src="../js/fx.js"></script>
	<script type="text/javascript" src="http://cdn.webfont.youziku.com/wwwroot/js/wf/youziku.api.min.js"></script>
	<script type="text/javascript" src="../js/pages/confirmOrder.js"></script>
</body>
</html>