@extends('layouts.app')

@section('title') 订单管理 @endsection

@section('css')
@endsection

@section('script')
    @parent
    <script type="text/javascript" src="{{ url('fx/common/dropload.js') }}"></script>
    <script>
        var page = 0;
        //定义全局对象
        var params = {state:'', serial:'',page:1};

        var dropload = $('.order_container').dropload({
            scrollArea : $('.order_container'),
            domUp : {
                domClass   : 'dropload-up',
                domRefresh : '<div class="dropload-refresh">↓下拉刷新</div>',
                domUpdate  : '<div class="dropload-update">↑释放更新</div>',
                domLoad    : '<div class="dropload-load"><span class="loading"></span>加载中...</div>'
            },
            domDown : {
                domClass   : 'dropload-down',
                domRefresh : '<div class="dropload-refresh">↑上拉加载更多</div>',
                domLoad    : '<div class="dropload-load"><span class="loading"></span>加载中...</div>',
                domNoData  : '<div class="dropload-noData">没有更多数据了</div>'
            },
            loadUpFn : function(me){
                getListData(me,'up');
            },
            loadDownFn : function(me){
                getListData(me,'down');
            },
            threshold : 50
        });

        //获取列表数据
        function getListData(me,type) {
            if (type=='down')
            {
                page++;
                params['page'] = page;
            }
            var result = '';
            var url = 'http://'+window.location.host + '/home/order/list/data';
            ajax('get', url, params, false, false, false).then(function (data) {
                if(data != ''){
                    result = joint(data);
                }else{
                    // 如果没有数据 锁定
                    me.lock();
                    // 无数据
                    me.noData();
                }
                $('.order_list').append(result);// 插入数据到页面，放到最后面
                $(".J_opts").off('click tap').on('click tap', orderOpts)
                me.resetload();// 每次数据插入，必须重置
                if (type == 'up') {
                    page = 0;// 重置页数，重新获取loadDownFn的数据
                    // 解锁loadDownFn里锁定的情况
                    me.unlock();
                    me.noData(false);
                }
            })
            .catch(function (err) {
                console.log(err)
                me.unlock();
                me.noData(false);
                // me.resetload();// 即使加载出错，也得重置
            })
        }

        // 拼接HTML
        function joint(data){
            var result = a = b = c = '';
            var len = 0;
            $.each(data, function(index, value, array) {
                len = value.length;
                $.each(value, function(index2, value2, array2) {
                    var ts = '';
                    var state = value2['order_state'];
                    var oid = value2['order_id'];
                    var method = value2['order_method'];
                    var img = value2['img'];
                    var name = value2['name'];
                    var desc = value2['desc'];
                    var price = value2['order_product_price'];
                    var amount = value2['order_amount'];
                    var price_raw = value2['price'];
                    var count = value2['order_price'];
                    var date = value2['order_date'];
                    var serial = value2['serial'];
                    b = '<div class="order_warpper_info">'+
                        '<div class="order_warpper_info_img pull-left mr-20">' +
                            '<img src="http://'+ window.location.host +'/'+ img +'">' +
                        '</div>'+
                        '<div class="order_warpper_info_detail pull-left mr-20">'+
                            '<h5 class="chayefont mb-10">' + name + '</h5>'+
                            '<p>' + desc + '</p>'+
                        '</div>'+
                        '<div class="order_warpper_info_price pull-left txt-r">'+
                            '<span class="block price">&yen' + price + '</span>'+
                            '<del class="block price_raw">&yen' + price_raw + '</del>'+
                            '<span class="block times">&times'+amount+'</span>'+
                        '</div>'+ '</div>';
                    if (index2 < 1) {    
                        a = '<div class="order_warpper mb-20">' +
                                '<div class="order_warpper_tit">' + 
                                '<h1 class="pull-left chayefont">' +
                                '<i class="fa fa-ban"></i>' + serial +
                                '<i class="fa fa-angle-right ml-20"></i>' + '</h1>' +
                                '<span class="pull-right chayefont">'+ date + '</span>'+'</div>';
                        c = '<div class="order_warpper_sum txt-r">'+'<span>总' + len + '件商品</span>'+
                                '<span>合计：<i class="price">&yen' + count + '</i>（包运费）</span>'+
                                '</div>'+'<div class="order_warpper_opts">'+'<ul class="pull-right">';
                                if (state == 'cancell' && method != 'self') {
                                    c += '<li>'+'<a href="javascript:;" class="chayefont">'+'订单已取消'+'</a>'+'</li>';
                                }
                                if (state == 'pading' && method != 'self') {
                                    c += '<li class="J_opts" type="cancell" oid="'+oid+'">'+'<a href="javascript:;" class="chayefont point">'+'取消订单'+'</a>'+'</li>'+
                                    '<li class="J_opts" type="pay" oid="'+oid+'">'+'<a href="javascript:;" class="chayefont point">'+'付款'+'</a>'+'</li>';
                                }
                                if (state == 'paid' && method != 'self') {
                                    c += '<li class="J_opts" type="back" oid="'+oid+'">'+'<a href="javascript:;" class="chayefont point">'+'申请退货'+'</a>'+'</li>';
                                }
                                if (state == 'delivery' && method != 'self') {
                                    c += '<li class="J_opts" type="delivery" oid="'+oid+'">'+'<a href="javascript:;" class="chayefont point">'+'查看物流'+'</a>'+'</li>'+
                                    '<li class="J_opts" type="take" oid="'+oid+'">'+'<a href="javascript:;" class="chayefont  point">'+'确定收货'+'</a>'+'</li>';
                                }
                                if (state == 'take' && method != 'self') {
                                    c += '<li class="J_opts" type="comment" oid="'+oid+'">'+'<a href="javascript:;" class="chayefont point">'+'立即评价'+'</a>'+'</li>';
                                }
                                if (state == 'backn' && method != 'self') {
                                    c += '<li class="J_opts" type="back" oid="'+oid+'">'+'<a href="javascript:;" class="chayefont point">'+'退货处理'+'</a>'+'</li>';
                                }
                                if (method == 'self') {
                                    c +='<li class="J_opts" type="back" oid="'+oid+'">'+'<a href="javascript:;" class="chayefont point">'+'申请退货'+'</a>'+'</li>'+
                                    '<li class="J_opts" type="code" oid="'+oid+'">'+'<a href="javascript:;" class="chayefont  point">'+'生成二维码'+'</a>'+'</li>';
                                }
                        c += '</ul>'+'</div>'+'</div>';
                        result += a + b;
                    } else {
                        result += b;
                    }    
                });
                result += c;
            });
            return result;
        }

        //订单功能按钮点击
        function orderOpts() {
            var type = $(this).attr('type');
            var id = $(this).attr('oid');
            if (type == 'pay') { order_pay(id); }
            if (type == 'back') { order_back(id); }
            if (type == 'take') { order_take(id); }
            if (type == 'code') { order_code(id); }
            if (type == 'comment') { order_comment(id); }
            if (type == 'cancell') { order_cancell(id); }
            if (type == 'delivery') { order_delivery(id); }
        }

        //订单state状态改变调用方法
        function orderOperate(addurl, pro, params) {
            var url = 'http://'+window.location.host + '/home/order/';
            url+= addurl;
            ajax('get', url, params).then(function (data) {
                if (data == 200) {
                    prompt.message(pro+'成功');
                    searchOrder(false);
                } else {
                    prompt.message(pro+'失败！请稍后再试！');
                }
            })
        }

        //取消订单方法
        function order_cancell(id){
            var params = {id:id};
            prompt.question('是否要取消该订单', function () {
                orderOperate('cancell', '取消订单', params);
            })
        }

        //申请退货方法
        function order_back(id){
            var params = {id:id};
            prompt.question('是否要申请退货', function () {
                orderOperate('back', '申请退货', params);
            })
        }

        //查看物流方法
        function order_delivery(id){
            window.location.href = 'http://'+window.location.host + '/home/order/delivery/'+id;
        }

        //确定收货方法
        function order_take(id){
            var params = {id:id};
            prompt.question('是否确认收货', function () {
                orderOperate('take', '确认收货', params);
            })
        }

        //生成二维码方法
        function order_code(id){
            var qrcode = new QRCode(document.getElementById("qrcode"), {
                text: "http://jindo.dev.naver.com/collie",
                width: 2000,
                height: 2000
            })
            prompt.message('二维码生成中')
            setTimeout(function () {
                prompt.qrcode()
            }, 1010)
        }
        
        //订单评论方法
        function order_comment(id){
            window.location.href = 'http://'+window.location.host + '/home/order/comment/'+id;
        }

        //付款方法
        function order_pay(id){
            window.location.href = 'http://'+window.location.host + '/home/order/pay/'+id;
        }

        //按钮点击(订单筛选)
        $(".J_tabs").on('click tap', function(){
            $(this).addClass('active').siblings().removeClass('active')
            params['state'] = $(this).attr('state');
            params['serial'] = '';
            searchOrder(false);
        });

        //搜索方法
        function searchOrder(sear) {
            var result = '';
            params['page'] = 1;// 重置页数，重新获取loadDownFn的数据
            var url = 'http://'+window.location.host + '/home/order/list/data';
            ajax('get', url, params).then(function (data) {
                result = joint(data);
                $('.order_list').html(result);// 插入数据到页面，放到最后面
                dropload.resetload()
                $(".J_opts").on('click tap', orderOpts)
            })
        }

        // 提交查询按钮
        $('.J_serialSubmit').on('click tap', function(){
            params['serial'] = $('#orderSerial').val();
            params['state'] = '';
            $(".J_tabs[state='']").addClass('active').siblings().removeClass('active');
            searchOrder(true);
        })
    </script>
@endsection

@section('content')

    @include("layouts.header-info")
    
    <div class="container order">
        <div class="order_search">
            <input type="text" placeholder="商品名称／商品编号／订单号" id="orderSerial">
            <i class="fa fa-search"></i>
            <i class="fa fa-chevron-circle-right J_serialSubmit"></i>
            <!-- <input type="submit" id="serialSubmit"> -->
        </div>
        <div class="order_tabs">
            <ul>
                <li class="active J_tabs" state=''>
                    <i class="fa fa-align-justify"></i>
                    <p>全部</p>
                </li>
                <li class="J_tabs" state='pading'>
                    <i class="fa fa-money"></i>
                    <p>待付款</p>
                </li>
                <li class="J_tabs" state='self'>
                    <i class="fa fa-map-marker"></i>
                    <p>待取货</p>
                </li>
                <li class="J_tabs" state='paid'>
                    <i class="fa fa-feed"></i>
                    <p>待发货</p>
                </li>
                <li class="J_tabs" state='delivery'>
                    <i class="fa fa-car"></i>
                    <p>待收货</p>
                </li>
                <li class="J_tabs" state='take'>
                    <i class="fa fa-comment-o"></i>
                    <p>待评价</p>
                </li>
            </ul>
        </div>
        <div class="order_container">
            <div class="order_list">
        <!--    <div class="order_warpper mb-20">
                    <div class="order_warpper_tit">
                        <h1 class="pull-left chayefont">
                            <i class="fa fa-ban"></i>
                            绿茶宝塔镇河妖
                            <i class="fa fa-angle-right ml-20"></i>
                        </h1>
                        <span class="pull-right chayefont">等待买家付款</span>
                    </div>
                    <div class="order_warpper_info">
                        <div class="order_warpper_info_img pull-left mr-20">
                            <img src="{{url('fx/images/goods_avatar.png')}}">
                        </div>
                        <div class="order_warpper_info_detail pull-left mr-20">
                            <h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
                            <p>新鲜梨酥雪梨发货供货的供货皇冠分隔符梨</p>
                        </div>
                        <div class="order_warpper_info_price pull-left txt-r">
                            <span class="block price">&yen212.00</span>
                            <del class="block price_raw">&yen299.00</del>
                            <span class="block times">&times2</span>
                        </div>
                    </div>
                    <div class="order_warpper_sum txt-r">
                        <span>总2件商品</span>
                        <span>合计：<i class="price">&yen424.00</i>（包运费）</span>
                    </div>
                    <div class="order_warpper_opts">
                        <ul class="pull-right">
                            <li>
                                <a href="javascript:;" class="chayefont">
                                    联系卖家
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" class="chayefont">
                                    取消订单
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" class="chayefont point">
                                    付款
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="order_warpper mb-20">
                    <div class="order_warpper_tit">
                        <h1 class="pull-left chayefont">
                            <i class="fa fa-ban"></i>
                            绿茶宝塔镇河妖
                            <i class="fa fa-angle-right ml-20"></i>
                        </h1>
                        <span class="pull-right chayefont">等待买家付款</span>
                    </div>
                    <div class="order_warpper_info">
                        <div class="order_warpper_info_img pull-left mr-20">
                            <img src="{{url('fx/images/goods_avatar.png')}}">
                        </div>
                        <div class="order_warpper_info_detail pull-left mr-20">
                            <h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
                            <p>新鲜梨酥雪梨发货供货的供货皇冠分隔符梨</p>
                        </div>
                        <div class="order_warpper_info_price pull-left txt-r">
                            <span class="block price">&yen212.00</span>
                            <del class="block price_raw">&yen299.00</del>
                            <span class="block times">&times2</span>
                        </div>
                    </div>
                    <div class="order_warpper_sum txt-r">
                        <span>总2件商品</span>
                        <span>合计：<i class="price">&yen424.00</i>（包运费）</span>
                    </div>
                    <div class="order_warpper_opts">
                        <ul class="pull-right">
                            <li>
                                <a href="javascript:;" class="chayefont point">
                                    生成二维码
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="order_warpper mb-20">
                    <div class="order_warpper_tit">
                        <h1 class="pull-left chayefont">
                            <i class="fa fa-ban"></i>
                            绿茶宝塔镇河妖
                            <i class="fa fa-angle-right ml-20"></i>
                        </h1>
                        <span class="pull-right chayefont">等待买家付款</span>
                    </div>
                    <div class="order_warpper_info">
                        <div class="order_warpper_info_img pull-left mr-20">
                            <img src="{{url('fx/images/goods_avatar.png')}}">
                        </div>
                        <div class="order_warpper_info_detail pull-left mr-20">
                            <h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
                            <p>新鲜梨酥雪梨发货供货的供货皇冠分隔符梨</p>
                        </div>
                        <div class="order_warpper_info_price pull-left txt-r">
                            <span class="block price">&yen212.00</span>
                            <del class="block price_raw">&yen299.00</del>
                            <span class="block times">&times2</span>
                        </div>
                    </div>
                    <div class="order_warpper_sum txt-r">
                        <span>总2件商品</span>
                        <span>合计：<i class="price">&yen424.00</i>（包运费）</span>
                    </div>
                </div>
                <div class="order_warpper mb-20">
                    <div class="order_warpper_tit">
                        <h1 class="pull-left chayefont">
                            <i class="fa fa-ban"></i>
                            绿茶宝塔镇河妖
                            <i class="fa fa-angle-right ml-20"></i>
                        </h1>
                        <span class="pull-right chayefont">等待买家付款</span>
                    </div>
                    <div class="order_warpper_info">
                        <div class="order_warpper_info_img pull-left mr-20">
                            <img src="{{url('fx/images/goods_avatar.png')}}">
                        </div>
                        <div class="order_warpper_info_detail pull-left mr-20">
                            <h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
                            <p>新鲜梨酥雪梨发货供货的供货皇冠分隔符梨</p>
                        </div>
                        <div class="order_warpper_info_price pull-left txt-r">
                            <span class="block price">&yen212.00</span>
                            <del class="block price_raw">&yen299.00</del>
                            <span class="block times">&times2</span>
                        </div>
                    </div>
                    <div class="order_warpper_sum txt-r">
                        <span>总2件商品</span>
                        <span>合计：<i class="price">&yen424.00</i>（包运费）</span>
                    </div>
                    <div class="order_warpper_opts">
                        <ul class="pull-right">
                            <li>
                                <a href="javascript:;" class="chayefont">
                                    联系卖家
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" class="chayefont">
                                    查看物流
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" class="chayefont point">
                                    确定收货
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="order_warpper mb-20">
                    <div class="order_warpper_tit">
                        <h1 class="pull-left chayefont">
                            <i class="fa fa-ban"></i>
                            绿茶宝塔镇河妖
                            <i class="fa fa-angle-right ml-20"></i>
                        </h1>
                        <span class="pull-right chayefont">等待买家付款</span>
                    </div>
                    <div class="order_warpper_info">
                        <div class="order_warpper_info_img pull-left mr-20">
                            <img src="{{url('fx/images/goods_avatar.png')}}">
                        </div>
                        <div class="order_warpper_info_detail pull-left mr-20">
                            <h5 class="chayefont mb-10">菲律宾进口香蕉</h5>
                            <p>新鲜梨酥雪梨发货供货的供货皇冠分隔符梨</p>
                        </div>
                        <div class="order_warpper_info_price pull-left txt-r">
                            <span class="block price">&yen212.00</span>
                            <del class="block price_raw">&yen299.00</del>
                            <span class="block times">&times2</span>
                        </div>
                    </div>
                    <div class="order_warpper_sum txt-r">
                        <span>总2件商品</span>
                        <span>合计：<i class="price">&yen424.00</i>（包运费）</span>
                    </div>
                    <div class="order_warpper_opts">
                        <ul class="pull-right">
                            <li>
                                <a href="javascript:;" class="chayefont point">
                                    评价
                                </a>
                            </li>
                        </ul>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <!-- 联系卖家 -->
    <!-- 取消订单 -->
    <!-- 付款 -->

    <!-- 生成二维码 -->

    <!-- 联系卖家 -->
    <!-- 查看物流 -->
    <!-- 确定收货 -->

    <!-- 评价 -->
    @include("layouts.footer")
@endsection
