<html>
<head>
<meta charset="utf-8">
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js"></script>
</head>
<body>
<center>  
  <h1 onclick="shareFriend();">分享朋友</h1>
  <h1 onclick="shareTimeline();">分享朋友圈</h1>
  <h1 onclick="shareWeibo();">分享微博</h1>
  <br/>
  <h1 onclick="fd();">分享朋友圈</h1>
</center>
</body>
</html>
<script>

    var imgUrl = "https://www.huceo.com/logo.jpg";  //注意必须是绝对路径
    var lineLink = "http://fx.caishi360.com";   //同样，必须是绝对路径
    var descContent = '我都这里等着你。'; //分享给朋友或朋友圈时的文字简介
    var shareTitle = '微信电台精选';  //分享title
    var appid = ''; //apiID，可留空
     
    function fd(){
      wx.onMenuShareTimeline({
          title: shareTitle, // 分享标题
          link: lineLink, // 分享链接
          imgUrl: imgUrl, // 分享图标
          success: function () { 
              // 用户确认分享后执行的回调函数
          },
          cancel: function () { 
              // 用户取消分享后执行的回调函数
          }
      });
    }

    function shareFriend() {
        WeixinJSBridge.invoke('sendAppMessage',{
            "appid": appid,
            "img_url": imgUrl,
            "img_width": "200",
            "img_height": "200",
            "link": lineLink,
            "desc": descContent,
            "title": shareTitle
        }, function(res) {
            //_report('send_msg', res.err_msg);
        })
    }
    function shareTimeline() {
        WeixinJSBridge.invoke('shareTimeline',{
             "img_url": imgUrl,
             "img_width": "200",
             "img_height": "200",
             "link": lineLink,
             "desc": descContent,
             "title": shareTitle
         }, function(res) {
                //_report('timeline', res.err_msg);
         });
    }
    function shareWeibo() {
         WeixinJSBridge.invoke('shareWeibo',{
             "content": descContent,
             "url": lineLink,
         }, function(res) {
             //_report('weibo', res.err_msg);
         });
    }
    // 当微信内置浏览器完成内部初始化后会触发WeixinJSBridgeReady事件。
    document.addEventListener('WeixinJSBridgeReady', function onBridgeReady() {
        // 发送给好友
        WeixinJSBridge.on('menu:share:appmessage', function(argv){
            shareFriend();
        });
        // 分享到朋友圈
        WeixinJSBridge.on('menu:share:timeline', function(argv){
            shareTimeline();
        });
        // 分享到微博
        WeixinJSBridge.on('menu:share:weibo', function(argv){
            shareWeibo();
        });
    }, false);
</script>