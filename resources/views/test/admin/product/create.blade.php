@extends('layouts.newapp')
@section('script')
	@include('UEditor::head')
@endsection
@section('content')
<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Panel title</h3>
    </div>
    <div class="panel-body">
        <form action="{{url('/admin/product')}}" method="POST"  enctype="multipart/form-data">
        	{{ csrf_field() }}
        	商品标题：<input type="text" name="title"><br>
        	商品分类：<select name = "category">
                @foreach(App\ProductCategory::whereNotNull('parent_id')->get() as $temp)
                        <option value={{$temp->id}}>{{$temp->name}}</option>
                @endforeach   
            </select><br><br>
            商品描述：
            <!-- 加载编辑器的容器 -->
			<script id="container" name="content" type="text/plain"></script>

			<!-- 实例化编辑器 -->
			<script type="text/javascript">
			    var ue = UE.getEditor('container');
			        ue.ready(function() {
			        ue.execCommand('serverparam', '_token', '{{ csrf_token() }}');//此处为支持laravel5 csrf ,根据实际情况修改,目的就是设置 _token 值.    
			    });
			</script>
			<br>
            <input type="submit" name="submit" value="保存">
            <br>
        </form>
    </div>
</div>
@endsection