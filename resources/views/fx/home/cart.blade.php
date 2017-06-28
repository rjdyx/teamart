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
        var size = 10;
        $('.cart_container').dropload({
            scrollArea : $('.cart_container'),
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
                $.ajax({
                    type: 'GET',
                    url: 'json/update.json',
                    dataType: 'json',
                    success: function(data){
                        var result = '';
                        for(var i = 0; i < data.lists.length; i++){
                            result +=   '<a class="item opacity" href="'+data.lists[i].link+'">'
                                            +'<img src="'+data.lists[i].pic+'" alt="">'
                                            +'<h3>'+data.lists[i].title+'</h3>'
                                            +'<span class="date">'+data.lists[i].date+'</span>'
                                        +'</a>';
                        }
                        // 为了测试，延迟1秒加载
                        setTimeout(function(){
                            $('.lists').html(result);
                            // 每次数据加载完，必须重置
                            me.resetload();
                            // 重置页数，重新获取loadDownFn的数据
                            page = 0;
                            // 解锁loadDownFn里锁定的情况
                            me.unlock();
                            me.noData(false);
                        },1000);
                    },
                    error: function(xhr, type){
                        alert('Ajax error!');
                        // 即使加载出错，也得重置
                        me.resetload();
                    }
                });
            },
            loadDownFn : function(me){
                page++;
                // 拼接HTML
                var result = '';
                $.ajax({
                    type: 'GET',
                    url: 'http://ons.me/tools/dropload/json.php?page='+page+'&size='+size,
                    dataType: 'json',
                    success: function(data){
                        var arrLen = data.length;
                        if(arrLen > 0){
                            for(var i=0; i<arrLen; i++){
                                result +=   '<a class="item opacity" href="'+data[i].link+'">'
                                                +'<img src="'+data[i].pic+'" alt="">'
                                                +'<h3>'+data[i].title+'</h3>'
                                                +'<span class="date">'+data[i].date+'</span>'
                                            +'</a>';
                            }
                        // 如果没有数据
                        }else{
                            // 锁定
                            me.lock();
                            // 无数据
                            me.noData();
                        }
                        // 为了测试，延迟1秒加载
                        setTimeout(function(){
                            // 插入数据到页面，放到最后面
                            $('.lists').append(result);
                            // 每次数据插入，必须重置
                            me.resetload();
                        },1000);
                    },
                    error: function(xhr, type){
                        alert('Ajax error!');
                        // 即使加载出错，也得重置
                        me.resetload();
                    }
                });
            },
            threshold : 50
        });
    </script>
@endsection

@section('content')

    @include("layouts.header-info")
    
    <div class="cart">
        <div class="cart_container">
            <div class="cart_list">
                @foreach($lists as $list)
                <div class="cart_warpper mb-20">
                    <div class="cart_warpper_tit">
                        <a href="javascript:;" class="chayefont">
                            <i class="fa fa-ban"></i>
                            绿茶宝塔镇河妖
                        </a>
                    </div>
                    <div class="cart_warpper_content clearfix">
                        <div class="cart_warpper_content_img pull-left mr-20">
                            <img src="{{url('')}}{{ $list->img }}">
                        </div>
                        <div class="cart_warpper_content_info pull-right">
                            <h5 class="chayefont mb-10">{{$list->name}}</h5>
                            <p>{{$list->desc}}</p>
                            <div class="cart_warpper_content_info_bottom">
                                <span class="pull-left price">{{'￥'.$list->price}}</span>
                                <div class="cwcib_number pull-right">
                                    <i class="fa fa-minus-circle"></i>
                                    <span class="sell">&times{{$list->amount}}</span>
                                    <i class="fa fa-plus-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                    @endforeach
            </div>
        </div>
        <div class="cart_bottom">
            <span class="cart_bottom_selection pull-left">全选</span>
            <div class="cart_bottom_info pull-left">合计：<span class="price">&yen{{$totals}}</span></div>
            <div class="cart_bottom_settle pull-right"><a href="{{url('/home/order/confirm')}}">结算</a></div>
            <div class="cart_bottom_del pull-right"><a href="javascript:;">删除</a></div>
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
