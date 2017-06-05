@extends('layouts.newapp')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Panel title</h3>
    </div>
    <div class="panel-body">
        <a href="{{url('/admin/product/create')}}">新增</a>
        @foreach($products as $product)
            <div class="panel  panel-default">
                <div class="panel-heading">
                    <p>{{$product->title}}</p>
                    <div><a href="{{url('/admin/product/'.$product->id.'/edit')}}">修改商品</a></div>
                </div>
                <div class="panel-body">
                    <div>所属分类：@if($product->category!=null)
                    {{$product->category->name}}
                    @else
                    请重新选择分类
                    @endif</div>
                    <div>销售量：{{$product->salesVolume}}</div>
                    <div>状态：{{App\Product::STATUS[$product->status]}}</div>
                    {{--<div>{!!$product->description!!}</div>--}}
                    <div><a href={{url('/admin/product/'.$product->id.'/type')}}>管理类型</a></div>
                    <div><a href={{url('/admin/product/'.$product->id.'/image')}}>管理图片</a></div>
                    <form action={{url('admin/product/'.$product->id.'')}} method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type ="submit">
                            删除
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
    <div class="text-center">
        {{ $products->links() }}
    </div>
</div>
@endsection