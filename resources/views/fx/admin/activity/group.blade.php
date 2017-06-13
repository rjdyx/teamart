@extends('fx.admin.layouts.app')

@section('title')
团购活动
@endsection

@section('css')

@endsection

@section('script')
    @parent

@endsection

@section('content')
   @include("fx.admin.layouts.header")

   @include("fx.admin.layouts.left")
   
   <div class="content-wrapper">团购活动 - 这是内容部分</div>

   @include("fx.admin.layouts.slide")
@endsection
