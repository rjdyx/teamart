$(function(){
	operation.fontFamily();
	operation.bgLayer();
});

var operation = {
	//字体转换
	fontFamily:function(){
		$youziku.load(".header_title,.products_nav_font,.products_details_name,.location_nav_name,.d_font,.way,.t_money,.quit_font,.sendWay_font", "f61ea8f5934348a2916e178809a3cbae", "yuweij");
	   	$youziku.draw();
	},
	//遮罩层
	bgLayer:function(){
		$('#chooseWay').click(function(){
			$('.bg').show();
			$('.sendWay').show().animate({bottom:"50px"},"fast");
			$('.quit').show().animate({bottom:"0px"},"fast");
		});
		$('.quit_font').click(function(){
			$('.bg').hide();
			$('.sendWay').hide().css({bottom:"-360px"});
			$('.quit').hide().css({bottom:"-410px"});
		});
	}
}