@extends('layouts.newapp')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <form action="{{url('/admin/productCategory')}}" method="POST">
                    {{ csrf_field() }}
                    分类名:<input type="text" name="name">
                    父分类:
                    <select name = "parent">
                        <option value=""></option>
                        @foreach(App\ProductCategory::whereNull('parent_id')->get() as $category)
                            <option value={{$category->id}}>{{$category->name}}</option>
                        @endforeach   
                    </select>
                    <input type="submit" name="submit" value="保存">
                </form>
            </div>
        </div>
    </div>
</div>
@endsection