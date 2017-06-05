$(function(){
	// 头部返回
	$(".header_turnBack").click(function(){
		window.history.back(-1);
	});
	//商品列表页跳转 
	$(".products_detail_a").prop("href","productDetail.html");
		console.log(window.location.href);
});