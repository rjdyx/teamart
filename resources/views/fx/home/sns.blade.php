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
  <h4>{{$data}}</h4>
</center>
</body>
</html>
<script>

    var _link = 'fx.caishi360.com';  //注意必须是绝对路径
    var _imgUrl = '';   //同样，必须是绝对路径
    var _title = '测试标题';  //分享title



    function shareFriend(){
          //获取“分享到朋友圈”按钮点击状态及自定义分享内容接口
        wx.onMenuShareTimeline({
            title: _title, // 分享标题
            link: _link, // 分享链接，该链接域名或路径必须与当前页面对应的公众号JS安全域名一致
            imgUrl: _imgUrl, // 分享图标
            success: function () { 
                // 用户确认分享后执行的回调函数
            },
            cancel: function () { 
                // 用户取消分享后执行的回调函数
            }
        });
    }

</script>