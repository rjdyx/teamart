<script src="http://cdn.bootcss.com/jquery/2.1.0/jquery.min.js"></script>
<script src="https://static.geetest.com/static/tools/gt.js"></script>
@define use Illuminate\Support\Facades\Config
<script>
    var geetest = function(url) { 
        //回调函数(未验证时)       
        var handlerEmbed = function(captchaObj) {
            //bind模式
            document.getElementById('valid').addEventListener('click', function () {
                if (valid()) { // 检查是否可以进行提交
                    var pm = submitForm()
                    pm.then(function (resolve) {
                        console.log(resolve)
                        if (resolve) {
                            captchaObj.verify();
                        }
                    })
                    .catch(function (reject) {
                        console.log(reject)
                    })
                }
            });
            captchaObj.onSuccess(function () {
                // 用户验证成功后，进行实际的提交行为
                $("#form").submit();
            });

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
