@extends('layouts.newapp')

@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Panel title</h3>
    </div>
    <div class="panel-body">
        <a href="{{url('/admin/productCategory/create')}}">新增</a>
        @foreach($categories as $category)
            <li>{{$category->name}}
            <a href={{url('/admin/productCategory/'.$category->id.'/edit')}}>编辑</a>   
            <form action={{url('admin/productCategory/'.$category->id.'')}} method="POST">
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <button type ="submit">
                    删除
                </button>
            </form></li>
            <ul>
                @foreach(App\ProductCategory::find($category->id)->children as $temp)
                    <li>{{$temp->name}}
                    <a href={{url('/admin/productCategory/'.$temp->id.'/edit')}}>编辑</a>   
                    <form action={{url('admin/productCategory/'.$temp->id.'')}} method="POST">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button type ="submit">
                            删除
                        </button>
                    </form></li>
                @endforeach
            </ul>
        @endforeach
    </div>
    <div class="text-center">
        {{ $categories->links() }}
    </div>
</div>
@endsection