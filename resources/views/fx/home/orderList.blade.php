@extends('layouts.app')

@section('title') 订单管理 @endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('fx/css/dropload.css') }}">
@endsection

@section('script')
    @parent
    <script type="text/javascript" src="{{ url('fx/common/dropload.js') }}"></script>
    <script>
        var page = 0;
        //定义全局对象
        var params = {state:'', serial:'',page:1};

        $('.order_container').dropload({
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
            axios.get(url, {params:params}).then(function (res) {
                var data = res.data.data
                var arrLen = data.length;

                if(arrLen > 0){
                    result = joint(data, arrLen);
                }else{
                    // 如果没有数据 锁定
                    me.lock();
                    // 无数据
                    me.noData();
                }
                $('.order_list').append(result);// 插入数据到页面，放到最后面
                me.resetload();// 每次数据插入，必须重置
                if (type == 'up') {
                    page = 0;// 重置页数，重新获取loadDownFn的数据
                    // 解锁loadDownFn里锁定的情况
                    me.unlock();
                    me.noData(false);
                }
            }).catch(function (err) {
                console.log(err)
                me.unlock();
                me.noData(false);
                // me.resetload();// 即使加载出错，也得重置
            });
        }

        // 拼接HTML
        function joint(data, arrLen){
            var result = '';
            for(var i=0; i<arrLen; i++){
                var ts = '';
                var state = data[i]['state'];
                var method = data[i]['method'];
                var img = data[i]['img'];
                var name = data[i]['name'];
                var desc = data[i]['desc'];
                var price = data[i]['order_price'];
                var amount = data[i]['order_amount'];
                var price_raw = data[i]['price_raw'];
                var count = price_raw * amount;
                var date = data[i]['order_date'];
                // if (state == 'pading') {ts = '等待买家付款';}
                // if (state == 'paid') {ts = '等待卖家发货';}
                // if (state == 'delivery') {ts = '等待买家收货';}
                // if (state == 'take') {ts = '等待买家评价';}
                // if (method == 'self') {ts = '等待买家提货';}

                result += '<div class="order_warpper mb-20">' +
                '<div class="order_warpper_tit">' + 
                '<h1 class="pull-left chayefont">' +
                '<i class="fa fa-ban"></i>' + data[i]['serial'] +
                '<i class="fa fa-angle-right ml-20"></i>' + '</h1>' +
                '<span class="pull-right chayefont">'+ date + '</span>' + '</div>'+
                '<div class="order_warpper_info">'+
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
                '</div>'+ '</div>' +
                '<div class="order_warpper_sum txt-r">'+
                    '<span>总' + amount + '件商品</span>'+
                    '<span>合计：<i class="price">&yen' + count + '</i>（包运费）</span>'+
                '</div>'+
                '<div class="order_warpper_opts">'+
                    '<ul class="pull-right">'+
                    '<li>'+ '<a href="javascript:;" class="chayefont">' +'联系卖家'+ '</a>'+'</li>'+
                    '<li>'+'<a href="javascript:;" class="chayefont">'+'取消订单'+'</a>'+'</li>'+
                    '<li>'+'<a href="javascript:;" class="chayefont point">'+'付款'+'</a>'+'</li>'+
                    '</ul>'+'</div>'+'</div>';
            }
            return result;
        }

        //按钮点击
        $(".order_tabs ul li").click(function(){
            $(".order_tabs ul li").removeClass('active');
            $(this).addClass('active');
            params['state'] = $(this).attr('state');
            params['serial'] = '';
            searchOrder(false);
        });

        //搜索方法
        function searchOrder(sear) {
            var result = '';
            var url = 'http://'+window.location.host + '/home/order/list/data';
            axios.get(url, {params:params}).then(function (res) {
                var data = res.data.data
                var arrLen = data.length;
                if(arrLen > 0){result = joint(data, arrLen);}
                $('.order_list').html(result);// 插入数据到页面，放到最后面
                page = 0;// 重置页数，重新获取loadDownFn的数据
            }).catch(function (err) {
                console.log(err);
            });
        }

        $('#serialSubmit').click(function(){
            params['serial'] = $('#orderSerial').val();
            params['state'] = '';
            $(".order_tabs ul li").removeClass('active');
            $(".order_tabs ul li[state='']").addClass('active');
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
            <!-- <input type="submit" id="serialSubmit"> -->
        </div>
        <div class="order_tabs">
            <ul>
                <li class="active" state=''>
                    <i class="fa fa-align-justify"></i>
                    <p>全部</p>
                </li>
                <li state='pading'>
                    <i class="fa fa-money"></i>
                    <p>待付款</p>
                </li>
                <li state='self'>
                    <i class="fa fa-map-marker"></i>
                    <p>待取货</p>
                </li>
                <li state='paid'>
                    <i class="fa fa-feed"></i>
                    <p>待发货</p>
                </li>
                <li state='delivery'>
                    <i class="fa fa-car"></i>
                    <p>待收货</p>
                </li>
                <li state='take'>
                    <i class="fa fa-comment-o"></i>
                    <p>待评价</p>
                </li>
            </ul>
        </div>
        <div class="order_container">
            <div class="order_list">
        <!-- <div class="order_warpper mb-20">
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
