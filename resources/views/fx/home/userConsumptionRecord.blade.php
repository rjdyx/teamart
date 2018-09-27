@extends('layouts.app')

@section('title')  @endsection
@section('css')
@endsection

@section('content')

    @include("layouts.header-info")

    @include("layouts.backIndex")
    <div class="container userassets">
        <div class="userassets_info relative">
            <div class="avatar">
                <img class="w-100" src="{{url('')}}/@if(Auth::user()){{Auth::user()->img}} @endif" alt="">
            </div>
            <p class="userassets_name white fz-20 txt-c chayefont">@if(Auth::user()){{Auth::user()->name}} @endif</p>
        </div>
        <div class="userassets_content mt-20 w-100">
            @if(count($userorderlist) == 0)
                <div class="userassets_content_row w-100" style="text-align: center;">
                    <span class="chayefont">暂无记录</span>
                </div>
            @else
                <div class="userassets_content_row w-100" style="text-align: center;">
                    <span class="pull-left chayefont">订单号</span>
                    <span class="chayefont">订单总额</span>
                    <span class="pull-right chayefont">时间</span>
                </div>
                @foreach($userorderlist as $orderitem)
                    <div class="userassets_content_row w-100" style="text-align: center;">
                        <span class="pull-left chayefont">{{$orderitem->serial}}</span>
                        <span class="chayefont">&yen;{{ sprintf("%.2f",$orderitem->price) }}</span>
                        <span class="pull-right chayefont">{{$orderitem->date}}</span>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
@endsection
