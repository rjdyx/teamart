@extends('layouts.newapp')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <form action="{{url('/admin/productCategory/'.$category->id)}}" method="POST">
                    <input name="_method" type="hidden" value="PUT">
                    {{ csrf_field() }}
                    分类名:<input type="text" name="name" value="{{$category->name}}">
                    父分类:
                    <select name = "parent">
                        <option value=""></option>
                        @if($category->parent_id!=null)
                            @foreach(App\ProductCategory::whereNull('parent_id')->get() as $temp)
                                @if($category->parent_id == $temp->id)
                                    <option value={{$temp->id}} selected>{{$temp->name}}</option>
                                @else
                                    <option value={{$temp->id}}>{{$temp->name}}</option>
                                @endif
                            @endforeach   
                        @endif
                    </select>
                    <input type="submit" name="submit" value="保存">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection