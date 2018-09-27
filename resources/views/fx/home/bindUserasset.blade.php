@extends('layouts.app')

@section('title') 个人资产 @endsection
@section('css')
@endsection
<style>
    .list-ul{
        display: flex;
        flex-direction: row;
        text-align: center;
        height: 0.8rem;
        line-height: 0.8rem;
        border-top:1px solid rgb(239,239,241);
    }
    .list-ul li{
        flex: 1;
    }
</style>

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
            @if(count($shareuserlist) == 0)
                <div class="list_nodata txt-c">
                    暂无记录
                </div>
            @else
                <div class="userassets_container_warpper w-100 p-10">
                    <ul class="list-ul ">
                        <li>
                            <p>用户名</p>
                        </li>
                        <li>
                            <p>邮件</p>
                        </li>
                        <li>
                            <p>联系电话</p>
                        </li>
                        <li>
                            <p>消费总额</p>
                        </li>
                    </ul>
                @foreach($shareuserlist as $shareitem)
                    <a href="{{url('/home/userconsumptionrecord').'/'.$shareitem->id}}" style="background: #fff;">
                        <ul class="list-ul ">
                            <li>
                                <p>{{$shareitem->name}}</p>
                            </li>
                            <li>
                                <p>{{$shareitem->email}}</p>
                            </li>
                            <li>
                                <p>{{$shareitem->phone}}</p>
                            </li>
                            <li>
                                <p>&yen;{{ sprintf("%.2f",$shareitem->price) }}</p>
                            </li>
                        </ul>
                    </a>
                @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
