@extends('layouts.app')

@section('title') 订单管理 @endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('fx/css/dropload.css') }}">
@endsection

@section('script')
    @parent
    <script type="text/javascript" src="{{ url('fx/common/dropload.js') }}"></script>
    <script>
        $(function () {
            var page = 0
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
                    getListData(me, 'up')
                },
                loadDownFn : function(me){
                    getListData(me, 'down')
                },
                threshold : 50
            });
            function getListData (me, type) {
                if (type == 'down') {
                    page++
                } else {
                    page = 0
                }
                ajax('get', '/home/cart/data', {page: page}, false, false, false)
                    .then(function (res) {
                        var template = ''
                        if (res.length > 0) {
                            res.forEach(function (v) {
                                template += `
                                    <div class="cart_warpper mb-20">
                                        <div class="cart_warpper_tit J_select">
                                            <a href="javascript:;" class="chayefont">
                                                <i class="fa fa-ban"></i>
                                                绿茶宝塔镇河妖
                                            </a>
                                        </div>
                                        <div class="cart_warpper_content clearfix">
                                            <div class="cart_warpper_content_img pull-left mr-20">
                                                <img src="${v.img}">
                                            </div>
                                            <div class="cart_warpper_content_info pull-right">
                                                <h5 class="chayefont mb-10">${v.name}</h5>
                                                <p>${v.desc}</p>
                                                <div class="cart_warpper_content_info_bottom">
                                                    <span class="pull-left price">￥${v.price}</span>
                                                    <div class="cwcib_number pull-right">
                                                        <i class="fa fa-minus-circle"></i>
                                                        <span class="sell">&times${v.amount}</span>
                                                        <i class="fa fa-plus-circle"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `
                            })
                        } else {
                            me.lock();
                            me.noData();
                        }
                        if (type == 'up') {
                            me.unlock();
                            me.noData(false);
                            $('.cart_list').html(result);
                        } else {
                            $('.cart_list').append(result);
                        }
                        me.resetload();
                    })
                    .catch(function (err) {
                        prompt.message('请求错误')
                        me.resetload()
                    })
            }
            var dels = [], confirm_params = {}
            $('.cart_warpper').each(function () {
                var cid = $(this).find('[data-id]').data('id')
                var camount = parseInt($(this).find('.amount').text())
                confirm_params[cid] = camount
            })
            console.log(confirm_params)
            $('.J_select').on('click tap', function () {
                if (!$(this).find('a').hasClass('active')) {
                    $(this).find('a').addClass('active')
                    dels.push($(this).data('id'))
                    if (dels.length == $('.J_select').length) {
                        $('.J_select_all').find('span').addClass('active')
                    }
                } else {
                    $(this).find('a').removeClass('active')
                    var arr = []
                    for (var i = 0; i < dels.length; i++) {
                        if (dels[i] != $(this).data('id')) {
                            arr.push(dels[i])
                        }
                    }
                    dels = arr
                }
                console.log(dels)
            })
            $('.J_select_all').on('click tap', function () {
                if (!$(this).find('span').hasClass('active')) {
                    $('.J_select')
                    .each(function () {
                        $(this).find('a').addClass('active')
                        dels.push($(this).data('id'))
                    })
                    $(this).find('span').addClass('active')
                } else {
                    $('.J_select')
                    .each(function () {
                        $(this).find('a').removeClass('active')
                        dels = []
                    })
                    $(this).find('span').removeClass('active')
                }
                console.log(dels)
            })
            $('.J_dels').on('click tap', function () {
                if (dels.length == 0) {
                    prompt.message('请选择要删除的商品')
                    return
                }
                ajax('post', '/home/cart/dels', dels)
                    .then(function (res) {
                        if (res) {
                            prompt.message('删除成功')
                        } else {
                            prompt.message('删除失败')
                        }
                    })
            })
            $('.J_minus').on('click tap', function () {
                var gid = $(this).parents('.cart_warpper').find('.J_select').data('id')
                if (confirm_params[gid] > 1) {
                    confirm_params[gid] -= 1
                    $(this).siblings('.sell').find('.amount').text(confirm_params[gid])
                } else {
                    prompt.message('单个商品数量最少为1')
                }
                console.log(confirm_params)
            })
            $('.J_plus').on('click tap', function () {
                var gid = $(this).parents('.cart_warpper').find('.J_select').data('id')
                confirm_params[gid] += 1
                $(this).siblings('.sell').find('.amount').text(confirm_params[gid])
                console.log(confirm_params)
            })
        })
    </script>
@endsection

@section('content')

    @include("layouts.header-info")
    
    <div class="cart">
        <div class="cart_container">
            <div class="cart_list">
                @foreach($lists as $list)
                <div class="cart_warpper mb-20">
                    <div class="cart_warpper_tit J_select" data-id="{{$list->id}}">
                        <a href="javascript:;" class="chayefont">
                            <i class="fa fa-ban"></i>
                            绿茶宝塔镇河妖
                        </a>
                    </div>
                    <div class="cart_warpper_content clearfix">
                        <div class="cart_warpper_content_img pull-left mr-20">
                            <img src="{{url('')}}/{{ $list->img }}">
                        </div>
                        <div class="cart_warpper_content_info pull-right">
                            <h5 class="chayefont mb-10">{{$list->name}}</h5>
                            <p>{{$list->desc}}</p>
                            <div class="cart_warpper_content_info_bottom">
                                <span class="pull-left price">{{'￥'.number_format($list->price,2)}}</span>
                                <div class="cwcib_number pull-right">
                                    <i class="fa fa-minus-circle J_minus"></i>
                                    <span class="sell">&times<span class="amount">{{$list->amount}}</span></span>
                                    <i class="fa fa-plus-circle J_plus"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="cart_bottom">
            <div class="cart_bottom_selection pull-left J_select_all">
                <span>全选</span>
            </div>
            <div class="cart_bottom_info pull-left">合计：<span class="price">&yen{{number_format($totals,2)}}</span></div>
            <div class="cart_bottom_settle pull-right"><a href="{{url('/home/order/confirm')}}">结算</a></div>
            <div class="cart_bottom_del pull-right J_dels"><a href="javascript:;">删除</a></div>
        </div>
    </div>
    @include("layouts.footer")
@endsection
