<script src="http://cdn.bootcss.com/jquery/2.1.0/jquery.min.js"></script>
<script src="https://static.geetest.com/static/tools/gt.js"></script>
<div id="geetest-captcha"></div>
<!-- <p id="wait" class="show">正在加载验证码...</p> -->
<p id="wait" class="show"></p>
@define use Illuminate\Support\Facades\Config
<script>
    var geetest = function(url) { 
        //回调函数(未验证时)       
        var handlerEmbed = function(captchaObj) {
            //bind模式
            document.getElementById('bid').addEventListener('click', function () {
                if (loginVali()) { // 检查是否可以进行提交
                    captchaObj.verify();
                }
            });
            captchaObj.onSuccess(function () {
                // 用户验证成功后，进行实际的提交行为
                $("#form").submit();
            });

            //默认模式
            // $("#geetest-captcha").closest('form').submit(function(e) {
            //     var validate = captchaObj.getValidate();
            //     if (!validate) {
            //         alert('{{ Config::get('geetest.client_fail_alert')}}');
            //         e.preventDefault();
            //     }
            // });
            // captchaObj.appendTo("#geetest-captcha");
            // captchaObj.onReady(function() {
            //     $("#wait")[0].className = "hide";
            // });
            // if ('{{ $product }}' == 'popup') {
            //     captchaObj.bindOn($('#geetest-captcha').closest('form').find(':submit'));
            //     captchaObj.appendTo("#geetest-captcha");
            // }
        };
        $.ajax({
            url: url + "?t=" + (new Date()).getTime(),
            type: "get",
            dataType: "json",
            success: function(data) {
                initGeetest({
                    gt: data.gt,
                    challenge: data.challenge,
                    product: "{{ $product }}",
                    offline: !data.success,
                    lang: '{{ Config::get('geetest.lang', 'zh-cn') }}'
                }, handlerEmbed);
            }
        });
    };
    (function() {
        geetest('{{ $geetest_url?$geetest_url:Config::get('geetest.geetest_url', 'geetest') }}');
    })();
</script>
<style>
.hide {
    display: none;
}
</style>