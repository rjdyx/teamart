@extends('layouts.app')

@section('title') 订单管理 @endsection

@section('css')
@endsection

@section('script')
    @parent
    <script>
        $(function () {
            var data = ['','收到商品破损','商品错发、漏发','收到商品与描述不符'];
            $("#submit").click(function(){
                if ($('#reason').val() == '') {
                    prompt.message('请选择退货理由')
                    return
                }
                if ($('#reason').val() == '1') {
                    if ($.trim($("#desc").val()).length < 5) {
                        prompt.message('退货理由不能少于5字')
                        return
                    }
                }
                var url = 'http://'+window.location.host + '/home/order/operate/backn';
                var params = {reason:data[$('#reason').val() - 1],desc:$("#desc").val(),id:"{{$id}}"};
                ajax('post', url, params).then(function (data) {
                    if (data == 200) {
                        prompt.message('申请成功');
                        //跳转到申请处理页 待补充...
                    } else {
                        prompt.message('申请失败！请稍后再试！');
                    }
                })
            });
            $('.J_show_select').on('click tap', function () {
                $('.backnreason_select').addClass('top-0')
            })
            $('.J_hide_select').on('click tap', function () {
                $('.backnreason_select').removeClass('top-0')
            })
            $('.J_choose_select').on('click tap', function () {
                $('#reason').val($(this).data('value'))
                if ($(this).data('value') == '1') {
                    $('#desc').removeAttr('disabled')
                } else {
                    $('#desc').attr('disabled', true).val('')
                }
                $(this).siblings().find('i').removeClass('active')
                $(this).find('i').addClass('active')
                $('.J_show_select').html($(this).find('span').text())
            })
        })
    </script>
@endsection

@section('content')

    @include("layouts.header-info")
    <div class="backnreason">
        <div class="backnreason_row">
            <span class="pull-left chayefont fz-18">退货理由</span>
            <span class="pull-right gray fz-14 J_show_select">
                <s>请选择</s><i class="fa fa-angle-right ml-10"></i>
            </span>
            <input type="hidden" value="" id="reason">
        </div>
        <div class="backnreason_row">
            <span class="pull-left chayefont fz-18">其它理由：</span>
        </div>
        <textarea class="backnreason_desc" id="desc" placeholder="（选填）其他退货的理由" disabled="true"></textarea>
        <div class="backnreason_bottom">
            <div class="pull-left submit chayefont fz-16" id="submit">申请退货</div>
            <div class="pull-left cancel chayefont fz-16" onclick="history.go(-1);">取消退货</div>
        </div>
    </div>
    <div class="backnreason_select">
        <div class="backnreason_select_container">
            <h5 class="chayefont fz-18">退货理由</h5>
            <div class="backnreason_select_list">
                <div class="backnreason_select_row J_choose_select" data-value="1">
                    <span class="pull-left chayefont fz-16">其他理由</span>
                    <i class="pull-right"></i>
                </div>
                <div class="backnreason_select_row J_choose_select" data-value="2">
                    <span class="pull-left chayefont fz-16">收到商品破损</span>
                    <i class="pull-right"></i>
                </div>
                <div class="backnreason_select_row J_choose_select" data-value="3">
                    <span class="pull-left chayefont fz-16">商品错发、漏发</span>
                    <i class="pull-right"></i>
                </div>
                <div class="backnreason_select_row J_choose_select" data-value="4">
                    <span class="pull-left chayefont fz-16">收到商品与描述不符</span>
                    <i class="pull-right"></i>
                </div>
            </div>
            <div class="backnreason_select_bottom chayefont fz-18 J_hide_select">关闭</div>
        </div>
    </div>
@endsection