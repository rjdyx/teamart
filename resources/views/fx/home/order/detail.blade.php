@extends('layouts.app')

@section('title') 订单详情 @endsection

@section('css')
@endsection

@section('script')
    @parent
    <script>
        // 评论内容省略
        $('.J_comment').on('tap', function () {
            $(this).toggleClass('active')
        })
        // 显示评论图片
        $('.J_show_img').on('tap', function () {
            prompt.image($(this).attr('src'))
        })
    </script>
@endsection

@section('content')

    @include("layouts.header-info")
    
    <div class="container orderdetail">
        <div class="orderdetail_state w-100">
            <span class="pull-left chayefont fz-18">订单号：</span>
            <span class="pull-right">{{$order->serial}}</span>
        </div>
        <div class="orderdetail_state w-100">
            <span class="pull-left chayefont fz-18">订单状态：</span>
            <span class="fz-14">
                @if ($order->state == 'pading') 未付款 @endif
                @if ($order->state == 'paid') 已付款 @endif
                @if ($order->state == 'delivery') 已发货 @endif
                @if ($order->state == 'take') 已收货 @endif
                @if ($order->state == 'backn') 退货申请中 @endif
                @if ($order->state == 'backy') 已退货 @endif
                @if ($order->state == 'close') 已完成 @endif
            </span>
            @if ($order->state == 'pading') 
            <a href="{{url('')}}/home/order/confirm?id={{$order->id}}" class="pull-right fz-14 state_btn txt-c price">去付款</a> 
            @endif
            @if ($order->state == 'delivery')
            <span class="pull-right fz-14 state_btn txt-c price">收货</span>
            @endif
            @if ($order->state == 'take')
            <a href="{{url('')}}/home/order/comment/{{$order->id}}" class="pull-right fz-14 state_btn txt-c price">去评价</a> 
            @endif
        </div>
        @if (!empty($order->delivery_serial))
            <!-- 物流 -->
            <div class="orderdetail_state w-100">
                <span class="pull-left">取货方式：</span>
                <span class="pull-right">@if($order->method == 'self')站点自取 @else 快递 @endif</span>
            </div>
            @if($order->method == 'delivery')
                <div class="orderdetail_state w-100">
                    <span class="pull-left">收货地址：</span>
                    <span class="pull-right">{{$order->p1.$order->p2.$order->p3.$order->p4}}</span>
                </div>
                <div class="orderdetail_state w-100">
                    <span class="pull-left">联系人：</span>
                    <span class="pull-right">{{$order->aname}}</span>
                </div>
                <div class="orderdetail_state w-100">
                    <span class="pull-left">联系电话：</span>
                    <span class="pull-right">{{$order->phone}}</span>
                </div>
                <div class="orderdetail_state w-100">
                    <span class="pull-left">{{$order->delivery_serial}}</span>
                    <span><a href="javascript:;" class="pull-right">物流详情</a></span>
                </div>
            @endif
        @endif

        <!-- 退货 -->
        @if ($order->type == 'backy' || $order->type == 'backn')
        <div class="backn mt-10">
            <div class="backn_reason w-100">
                <span class="pull-left chayefont fz-18">退货理由：</span>
            </div>
            <p class="hide">{{$order->reason}}</p>
        </div>
        @endif

        <!-- 总计 -->
        <div class="orderdetail_state w-100">
            <span class="pull-left">合计：</span>
            <span class="pull-right"><i class="price">&yen;{{$order->price}}</i> </span>
        </div>
    
        <!-- 商品 -->
        @foreach($datas as $data)
        <div class="orderdetail_container w-100 mb-20">
            <div class="orderdetail_warpper">
                <div class="warpper_img pull-left mr-20">
                    <a href="{{url('')}}/home/product/detail/{{$data->id}}" class="block w-100 h-100">
                        <img class="w-100" src="{{url('')}}/{{$data->thumb}}">
                    </a>
                </div>
                <div class="warpper_detail pull-left mr-20">
                    <h5 class="chayefont mb-10">
                        <a href="{{url('')}}/home/product/detail/{{$data->id}}">{{$data->name}}</a>
                    </h5>
                    <p class="color-8C8C8C">{{$data->desc}}</p>
                </div>
                <div class="warpper_price pull-left txt-r">
                    <span class="block price">&yen;{{$data->raw_price * $data->amount}}</span>
                    <del class="block price_raw color-8C8C8C">&yen;{{$data->price}}</del>
                    <span class="block times color-8C8C8C">&times;{{$data->amount}}</span>
                </div>
            </div>
            @if ($order->type=='close' || $order->type=='backn' || $order->type=='backy')
            <div class="comment mt-10">
                @if(!empty($data['comment']->id))
                    <!-- <h5 class="chayefont fz-18 mb-10">您的评价：</h5> -->
                    <div class="comment_grade color-8C8C8C mb-10">
                        <span>满意度：</span>
                        @for($i=0;$i<$data['comment']->cgrade/20;$i++)
                        <i class="fa fa-star stars"></i>
                        @endfor
                    </div>
                    <p class="comment_content w-100 mb-10 active J_comment">{{$data['comment']->content}}</p>
                    <ul class="comment_imgs w-100 clearfix">
                    @if(!empty($data['comment']->cthumb))
                        @foreach(explode(',',$data['comment']->cthumb) as $img)
                        <li class="pull-left mr-10">
                            <img src="{{url('')}}/{{$img}}" class="w-100 J_show_img" alt="">
                        </li>
                        @endforeach
                    @endif
                    </ul>
                    <!-- 评论回复 -->
                    @if (!empty($data['replys']))
                        @foreach($data['replys'] as $reply)
                    <div class="comment_grade mb-10">
                        <span>{{$reply->aname}} 回复 {{$reply->bname}} :({{$reply->created_at}})</span>
                    </div>
                        <p>{{$reply->content}}</p>
                        @endforeach
                    @endif
                @else
                    <p>暂无评价</p>
                @endif
            </div>
            @endif
        </div>
        @endforeach
    </div>
@endsection
