<!DOCTYPE html>
<html>
<head>
    <title>注册</title>
    <meta name="viewport" charset="UTF-8" content="width=device-width,initial-scale=1,user-scalable=no,minimal-ui">
    <meta name="format-detection" content="telephone=no">
    <link rel="stylesheet" type="text/css" href="../css/reset.css">
    <!--<link rel="stylesheet" type="text/css" href="../css/header.css">-->
    <link rel="stylesheet" type="text/css" href="../css/register.css">
    <script type="text/javascript" src="../js/zepto.min.js"></script>
    <script type="text/javascript" src="http://cdn.webfont.youziku.com/wwwroot/js/wf/youziku.api.min.js"></script>
    <script type="text/javascript">
        $youziku.load(".content", "f61ea8f5934348a2916e178809a3cbae", "yuweij");
        $youziku.draw();
    </script>
</head>
<body>
<div class="content">
    <div class="head">
        <img src="../img/pic52.png" style="width: 250px;height: 180px">
    </div>
    <div class="contain">
        <div class="number">
            <img src="../img/pic34.png" style="width: 20px;height:20px;vertical-align: middle;position: relative;left: 35px">
            <img src="../img/pic31.png" style="width: 250px;height:45px;vertical-align: middle;line-height: 60px">

            <input type="text" placeholder="供货的羊在哪里">
        </div>
        <div class="number">
            <img src="../img/pic35.png" style="width: 20px;height:20px;vertical-align: middle;position: relative;left: 35px">
            <img src="../img/pic31.png" style="width: 250px;height:45px;vertical-align: middle;line-height: 60px">
            <input type="password" placeholder="请输入密码">
        </div>
        <div class="number">
            <img src="../img/pic35.png" style="width: 20px;height:20px;vertical-align: middle;position: relative;left: 35px">
            <img src="../img/pic31.png" style="width: 250px;height:45px;vertical-align: middle;line-height: 60px">
            <input type="password" placeholder="请确认密码">
        </div>
        <div class="choose">
            <form class="form">
                <input type="radio" name="sex" value="male" checked='true' class="radio_left">
                <div class="radio_text"><div class="radio_left_box"></div>已有账号</div>
                <input type="radio" name="sex" value="female" style="margin-left: 20px" class="radio_right">
                <div class="radio_text"><div class="radio_right_box radio_selected"></div>注册说明</div>
            </form>
        </div>
        <!-- <div class="choose">
            <form>
                <input type="radio" name="sex" value="male" checked>已有账号
                <input type="radio" name="sex" value="female" style="margin-left: 20px">注册说明
            </form>
        </div> -->
        <div class="button">
        </div>
    </div>
    <div class="bottom">
    <img src="../img/pic50.png" style="width: 100%;height: 150px">
    </div>
</div>
<script type="text/javascript" src="../js/pages/register.js"></script>
</body>
</html>