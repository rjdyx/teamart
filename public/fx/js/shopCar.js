$(function(){
	operation.fontFamily();
});

var operation = {
	//字体转换
	fontFamily:function(){
		$youziku.load(".header_title,.products_nav_font,.products_details_name", "f61ea8f5934348a2916e178809a3cbae", "yuweij");
	   	$youziku.draw();
	}
}