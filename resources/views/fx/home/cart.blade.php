@extends('layouts.app')

@section('title') 订单管理 @endsection

@section('css')
@endsection

@section('script')
    @parent
    <script type="text/javascript" src="{{ url('fx/js/dropload.min.js') }}"></script>
    <script>
        $(function () {
            var page = 0
            var dels = [], confirm_params = {} , pids = []; // dels删除集合 pid商品id confirm_params商品ID对应数量
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
                    page = 1
                    $('.dropload-down').show()
                }
                ajax('get', '/home/cart/data', {page: page}, false, false, false)
                    .then(function (res) {
                        var template = ''
                        if (res.data.length > 0) {
                            res.data.forEach(function (v) {
                                template += `
                                    <div class="warpper mb-20 clearfix">
                                        <i class="warpper_select J_select" data-opid="${v.opid}" data-pid="${v.id}" data-price="${v.price}"></i>
                                        <div class="warpper_content_img pull-left mr-20">
                                            <img src="http://${window.location.host}/${v.img}">
                                        </div>
                                        <div class="warpper_content_info pull-right">
                                            <h5 class="chayefont mb-10">${v.name}</h5>
                                            <p class="desc">${v.desc}</p>
                                            <div class="warpper_content_info_bottom">
                                                <span class="pull-left price">&yen;${parseInt(v.price).toFixed(2)}</span>
                                                <div class="pull-right">
                                                    <i class="fa fa-minus-circle fz-18 color-d7d7d7 J_minus"></i>
                                                    <span class="sell color-8C8C8C" stock="${v.stock}">&times;<span class="amount" data-opid="${v.opid}" data-pid="${v.id}">${v.amount}</span></span>
                                                    <i class="fa fa-plus-circle fz-18 color-F78223 J_plus"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `
                            })
                        } else {
                            me.lock();
                            me.noData();
                            if (page == 1) {
                                $('.dropload-down').hide()
                                $('.cart_container').find('.list_nodata').remove()
                                $('.cart_container').append(`
                                <div class="list_nodata txt-c">
                                    你的购物车还没有商品，快去<a class="price" href="{{url('')}}">首页</a>看看吧
                                </div>`)
                            }
                        }
                        if (type == 'up') {
                            $('.cart_list').html(template);
                        } else {
                            $('.cart_list').append(template);
                        }
                        $('.warpper').each(function () {
                            var cid = $(this).find('.J_select').data('pid')
                            var camount = parseInt($(this).find('.amount').text())
                            confirm_params[cid] = camount
                        })
                        $('.J_select').off('tap').on('tap', selectSingle)
                        // 减少商品数量
                        $('.J_minus').off('tap').on('tap', minus)
                        // 增加商品数量
                        $('.J_plus').off('tap').on('tap', plus)
                        $('.J_select_all').find('span').removeClass('active')
                        me.resetload();
                        if (type == 'up') {
                            me.unlock();
                            me.noData(false);
                        }
                    })
                    .catch(function (err) {
                        console.dir(err)
                        prompt.message('请求错误')
                        // me.resetload()
                    })
            }

            // 单选
            function selectSingle () {
                if (!$(this).hasClass('active')) {
                    $(this).addClass('active')
                    dels.push($(this).data('opid'))
                    pids.push($(this).data('pid'))
                    if (dels.length == $('.J_select').length) {
                        $('.J_select_all').find('span').addClass('active')
                    }
                } else {
                    $(this).removeClass('active')
                    $('.J_select_all').find('span').removeClass('active')
                    var arr = [], brr = []
                    for (var i = 0; i < dels.length; i++) {
                        if (dels[i] != $(this).data('opid')) {
                            arr.push(dels[i])
                        }
                    }
                    for (var j = 0; j < pids.length; j++) {
                        if (pids[j] != $(this).data('pid')) {
                            brr.push(pids[j])
                        }
                    }
                    dels = arr
                    pids = brr
                }
                $('.bottom_btn').find('.total').text(totals())
            }

            // 全选
            $('.J_select_all').on('tap', function () {
                if (!$(this).find('span').hasClass('active')) {
                    dels = []
                    pids = []
                    $('.J_select')
                    .each(function () {
                        $(this).addClass('active')
                        dels.push($(this).data('opid'))
                        pids.push($(this).data('pid'))
                    })
                    $(this).find('span').addClass('active')
                } else {
                    $('.J_select')
                    .each(function () {
                        $(this).removeClass('active')
                        dels = []
                        pids = []
                    })
                    $(this).find('span').removeClass('active')
                }
                $('.bottom_btn').find('.total').text(totals)
                console.log(dels)
            })
            // 删除
            $('.J_dels').on('tap', function () {
                if (dels.length == 0) {
                    prompt.message('请选择要删除的商品')
                    return
                }
                prompt.question('是否删除',function () {
                    ajax('post', '/home/cart/dels', dels)
                        .then(function (res) {
                            if (res) {
                                prompt.message('删除成功')
                                $('.J_select').each(function () {
                                    var $this = $(this)
                                    dels.forEach(function (v) {
                                        if (v == $this.data('opid')) {
                                            $this.parent().remove()
                                        }
                                    })
                                })
                                dels = []
                                pids = []
                                $('.bottom_btn').find('.total').text('0.00')
                            } else {
                                prompt.message('删除失败')
                            }
                        })
                })
                
            })
            // 减少商品数量
            function minus () {
                var gid = $(this).parents('.warpper').find('.J_select').data('pid')
                if (confirm_params[gid] > 1) {
                    confirm_params[gid] -= 1
                    $(this).siblings('.sell').find('.amount').text(confirm_params[gid])
                    var id = $(this).siblings('.sell').find('.amount').data('opid')
                    updateAmount(id, confirm_params[gid]);
                } else {
                    prompt.message('单个商品数量最少为1')
                }
                console.log(confirm_params)
            }
            
            // 增加商品数量
            function plus () {
                var gid = $(this).parents('.warpper').find('.J_select').data('pid')
                var stock = $(this).siblings('.sell').attr('stock')
                if (stock >= confirm_params[gid]){
                    confirm_params[gid] += 1
                    $(this).siblings('.sell').find('.amount').text(confirm_params[gid])
                    var id = $(this).siblings('.sell').find('.amount').data('opid')
                    updateAmount(id, confirm_params[gid]);
                } else {
                    prompt.message('商品数量已达到库存上限')
                }
                console.log(confirm_params)
            }

            //修改商品数量
            function updateAmount(id, amount){
                var params = {id:id,amount:amount}
                ajax('post', '/home/cart/update/amount', params).then(function (res) {
                    if (!res) {
                        prompt.message('服务器异常！请稍后再试！')
                    }
                    $('.bottom_btn').find('.total').text(totals())
                })  
            }

            // 计算总价
            function totals () {
                console.log(dels)
                console.log(pids)
                var total = 0
                pids.forEach(function (v) {
                    var price = parseFloat($(`[data-pid="${v}"]`).data('price'))
                    total += price * confirm_params[v]
                })
                return total.toFixed(2)
            }

            // 结算
            $('.J_comfirm').on('tap', function () {
                if (dels.length == 0) {
                    prompt.message('请选择要结算的商品')
                    return
                }
                var params = {
                    data:{}
                }
                pids.forEach(function (v) {
                    params['data'][v] = $('.amount[data-pid="'+ v +'"]').html()
                })
                console.log(params)
                var url = 'http://' + window.location.host + '/home/order/confirm?id=';
                ajax('post', '/home/order/confirm', params)
                    .then(function (resolve) {
                        if (resolve) {
                            window.location.href = url + resolve;  
                        } else {
                            prompt.message('服务器异常！请稍后再试！')
                        }
                    })
            })
        })
    </script>
@endsection

@section('content')

    @include("layouts.header-info")
    
    <div class="cart">
        <div class="cart_container">
            <div class="cart_list">
                <!-- 收藏商品结构 -->
            </div>
        </div>
        <div class="bottom_btn">
            <div class="relative cart_bottom_selection txt-c pull-left J_select_all">
                <span>全选</span>
            </div>
            <div class="cart_bottom_info txt-c pull-left">合计：<span class="price">&yen;<span class="total">0.00</span></span></div>
            <div class="cart_bottom_settle txt-c pull-right J_comfirm"><a class="white" href="javascript:;">结算</a></div>
            <div class="cart_bottom_del txt-c pull-right J_dels"><a class="white" href="javascript:;">删除</a></div>
        </div>
    </div>
    @include("layouts.footer")
@endsection
