<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>访问设备出错啦...</title>
	<link rel="stylesheet" type="text/css" href="https://res.wx.qq.com/open/libs/weui/0.4.1/weui.css">
</head>
<body>
	<div class="weui_msg">
		<div class="weui_icon_area">
			<i class="weui_icon_info weui_icon_msg"></i>
		</div>
		<div class="weui_text_area">
			<h4 class="weui_msg_title">
				@if (isset($err) && !empty($err))
					@if ($err == 'pc')
						请在电脑端打开
					@else
						请在移动端打开
					@endif

				@else 
					访问设备错误
				@endif
			</h4>
		</div>
	</div>
</body>
</html>