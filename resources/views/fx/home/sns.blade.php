<html>
<head>
<meta charset="utf-8">
</head>
<body>
  <h1 onclick="wxa();">分享朋友圈</h1>
  <h1 onclick="wxb();">分享朋友</h1>
</body>
</html>
<script>

 var dataForWeixin = {
  appId: "wxdaa4107ed552fdcb",
  MsgImg: "",//显示图片
  TLImg: "",//显示图片
  url: "http://fx.caishi360.com",//跳转地址
  title: "自定义标题",//标题内容
  desc: "自定义描述"//描述内容
 };

  function wxa() {
     WeixinJSBridge.invoke('sendAppMessage', {
     "appid": dataForWeixin.appId,
     "img_url": dataForWeixin.MsgImg,
     "img_width": "120",
     "img_height": "120",
     "link": dataForWeixin.url,
     "desc": dataForWeixin.desc,
     "title": dataForWeixin.title
     }, function (res) { 
        alert(res)
      });
  }
  function wxb(){
    WeixinJSBridge.invoke('shareTimeline', {
     "img_url": dataForWeixin.TLImg,
     "img_width": "120",
     "img_height": "120",
     "link": dataForWeixin.url,
     "desc": dataForWeixin.desc,
     "title": dataForWeixin.title
     }, function (res) { 
        alert(res)
     });
  }

</script>