$(function(){
	header.init();
});

var header = {
	init:function(){
		header.buildHeader();
		header.bulidBottom();
		header.fontFamily();
	},

	buildHeader:function(){
		var headerTitle = $(".header").text();
		$(".header").text("");
		var headerTpl = "<div class='condition'></div>"
							+"<div class='header_turnBack'>返回</div>"
							+"<div class='msg'>"
								+"<div class='msg_container'>"
									+"<img src='../img/msg_tips.png' class='msg_tips'>"
									+"<div class='tips_count'>4</div>"
									+"<div class='msg_content'>消息</div>"
								+"</div>"
							+"</div>"
						+"<div class='header_title'>"+headerTitle+"</div>";
		$('.header').append(headerTpl);
	},

	bulidBottom:function(){
		var bottomTpl = "<ul class='bottom_container'>"
							+"<li>"
								+"<a href=''>"
									+"<img src='../img/home_actived.gif' class='bottom_img'>"
									+"<p class='bottom_content'>首页</p>"
								+"</a>"
							+"</li>"
							+"<li>"
								+"<a href=''>"
									+"<img src='../img/products.gif' class='bottom_img'>"
									+"<p class='bottom_content'>商品</p>"
								+"</a>"
							+"</li>"
							+"<li>"
								+"<a href=''>"
									+"<img src='../img/shoppingCart.png' class='bottom_img'>"
									+"<p class='bottom_content'>购物车</p>"
								+"</a>"
							+"</li>"
							+"<li>"
								+"<a href=''>"
									+"<img src='../img/collection.gif' class='bottom_img'>"
									+"<p class='bottom_content'>收藏</p>"
								+"</a>"
							+"</li>"
							+"<li>"
								+"<a href=''>"
									+"<img src='../img/person.png' class='bottom_img'>"
									+"<p class='bottom_content'>我的</p>"
								+"</a>"
							+"</li>"
						+"</ul>";
		$('.bottom').append(bottomTpl);
	},
	// 字体转换
	fontFamily:function(){
		$youziku.load(".header_title,.item_list,.userName,.bottom2", "f61ea8f5934348a2916e178809a3cbae", "yuweij");
		$youziku.draw();
	}
}