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

    var _link = 'fx.caishi360.com';  //注意必须是绝对路径
    var _imgUrl = '';   //同样，必须是绝对路径
    var _title = '测试标题';  //分享title

    var data = [];
    data['appid'] = "{{$appid}}";
    data['timestamp'] = "{{$timestamp}}";
    data['noncestr'] = "{{$noncestr}}";
    data['sign'] = "{{$sign}}";
    var jsApiList = ["onMenuShareTimeline","onMenuShareAppMessage","onMenuShareQQ","onMenuShareWeibo","onMenuShareQZone"];
    wx.config({
        debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
        appId: data['appid'], // 必填，公众号的唯一标识
        timestamp: data['timestamp'], // 必填，生成签名的时间戳
        nonceStr: data['noncestr'], // 必填，生成签名的随机串
        signature: data['sign'],// 必填，签名，见附录1
        jsApiList: jsApiList // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
    });

    wx.error(function(res){
        alert(res)
    });

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
  window.share_config = {
     "share": {
        "imgUrl": "http://www.yourwebsite.com/share.png",//分享图，默认当相对路径处理，所以使用绝对路径的的话，“http://”协议前缀必须在。
        "desc" : "你对页面的描述",//摘要,如果分享到朋友圈的话，不显示摘要。
        "title" : '分享卡片的标题',//分享卡片标题
        "link": window.location.host,//分享出去后的链接，这里可以将链接设置为另一个页面。
        "success":function(){//分享成功后的回调函数
        },
        'cancel': function () { 
            // 用户取消分享后执行的回调函数
        }
    }
  };
  wx.ready(function () {
    wx.onMenuShareAppMessage(share_config.share);//分享给好友
    wx.onMenuShareTimeline(share_config.share);//分享到朋友圈
    wx.onMenuShareQQ(share_config.share);//分享给手机QQ
  });
</script>