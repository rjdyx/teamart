@extends('fx.admin.layouts.app')

@section('title')
店铺设置
@endsection

@section('css')

@endsection

@section('script')
    @parent

@endsection

@section('content')
   @include("fx.admin.layouts.header")

   @include("fx.admin.layouts.left")
   
   <div class="content-wrapper">店铺设置 - 这是内容部分</div>

@endsection