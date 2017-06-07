<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Frameset//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-frameset.dtd">
<html>
<head>
	<title>个人资料</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no,minimal-ui">
	<meta name="format-detection" content="telephone=no">
	<link rel="stylesheet" type="text/css" href="../css/reset.css">
	<link rel="stylesheet" type="text/css" href="../css/personalInformation.css">
	<link rel="stylesheet" type="text/css" href="../css/header.css">
	<script type="text/javascript" src="../js/zepto.min.js"></script>
	<script type="text/javascript" src="http://cdn.webfont.youziku.com/wwwroot/js/wf/youziku.api.min.js"></script>
	<script type="text/javascript">
	   $youziku.load(".bottom2,.personal_assets_two_name,ul,p,.personal_info_two_name,.tea,.personal_info_list_input,.personal_info_list_select,#webfont", "f61ea8f5934348a2916e178809a3cbae", "yuweij");
	   $youziku.draw();
	</script>

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
		<div class='header_title'>我的资产</div>
	</div>

	<!-- 内容 -->
	<div class="personal_info_content">
		<div class="personal_assets_img_Bamboo">
			<div class="personal_assets_head_photo">
				<div class="img_background_shadow"></div>
			  	<div class="personal_assets_img_BlackCircle"></div>
			</div>
			<div class="personal_assets_two_name">
				<div class="personal_assets_name">王宝强</div>
		 		<div class="personal_assets_name" id="personal_assets_recommend_name">推荐人：隔壁老王</div>
			</div>
		</div>
		
		<div class="personal_info_div_list">
			<ul>
				<li id="personal_info_list_one" class="personal_info_list">
					<span class="personal_info_list_span">姓名：</span>
					<div class="personal_info_list_modify_div">
						<input class="personal_info_list_input" type="text" name="" placeholder="天王盖地虎">
					</div>
				</li>

				<li class="personal_info_list">
					<span class="personal_info_list_span">性别：</span>
					<div class="personal_info_list_modify_div">
						<select class="personal_info_list_select">
							<option selected="true">男</option>
							<option>女</option>
						</select>
					</div>
				</li>

				<li class="personal_info_list">
					<span class="personal_info_list_span">手机：</span>
					<div class="personal_info_list_modify_div">
						<input class="personal_info_list_input" type="text" name="" placeholder="13560449011">
					</div>
				</li>

				<li class="personal_info_list">
					<span class="personal_info_list_span">QQ：</span>
					<div class="personal_info_list_modify_div">
						<input class="personal_info_list_input" type="text" name="" placeholder="455010903">
					</div>
				</li>

				<li class="personal_info_list">
					<span class="personal_info_list_span">生日：</span>
					<div class="personal_info_list_modify_div">
						<select class="personal_info_list_select">
							<option selected="true">男</option>
							<option>女</option>
						</select>
					</div>
				</li>

				<li class="personal_info_list">
					<span class="personal_info_list_span">绑定手机号：</span>
					<div class="personal_info_list_modify_div">
						<input id="personal_info_list_last" class="personal_info_list_input" type="text" name="" placeholder="未绑定">
					</div>
				</li>
			</ul>
		</div>
	</div>
	
	<!-- 底部 -->
	<div class="bottom2">确定保存</div>
	
</body>
</html>