 @extends('fx.admin.layouts.app')
 @section('title')新增团购商品@endsection
 @section('t1')促销管理@endsection
 @section('css')
 <style>
  .checked{
    margin-right:15px;
  }
 </style>
 @endsection
 @section('script')
 @parent
 <script>
    //全选
    $("#checkedAll").change(function(){
      var state = $(this).prop('checked');
      $(".checkboxs").prop('checked',state);
    });

    // 获取选择结果
    function checkeds(){
      var data = [];
      $(".checkboxs").each(function(i){
        if ($(this).is(':checked')) {
          data[i] = $(this).val();
        }
      })
      return data;
    }
    // 表单提交
    $("form").submit(function(){
      var data = checkeds();
      if (data.length) {
        return true;
      }
      $("#product_id_txt").html('请选择商品后再提交');
      return false;
    });
 </script>
 @endsection
 @section('content')
 <section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-success">
        <div class="box-header with-border">
          <h3 class="box-title">新增团购商品</h3>
        </div>
        <form class="form-horizontal" action="{{url('admin/activity/activityproduct')}}" method="POST" name="listForm" enctype="multipart/form-data">
          <input type="hidden" name="activity_id" value="{{$_GET['activity_id']}}">
         {{ csrf_field() }}
        <div class="form-group">
          <label class="col-sm-3 control-label">活动名称：</label>
          <label class="col-sm-3 control-label" style="color:#00a65a">{{$activity['name']}}</label>
        </div>   
        <div class="form-group">
          <label class="col-sm-3 control-label"><i style="color:red;">*</i>商品：</label>
          <div class="col-sm-1"><input type="checkbox"  id="checkedAll">全选</div>
          <span class="col-sm-4 text-danger form_error" id="category_id_txt"></span>
        </div>   
              
        <div class="form-group">
          <label class="col-sm-3 control-label"></label>
          <div class="col-sm-4">
          @foreach($products as $p)
            <span class="checked">
              <input type="checkbox" value="{{$p->id}}" name="pid[]" class="checkboxs">{{$p->name}}
            </span>
          @endforeach
          @if (!count($products))
          <span class="checked" style="color:red">*没有可添加的商品啦~</span>
          @endif
          </div>
          <span class="col-sm-4 text-danger form_error" id="product_id_txt"></span>
        </div>   

        <div class="form-group">
          <div class="col-sm-offset-3 col-sm-10">
            <button type="submit" class="btn btn-success btn-100">确认</button>
            <button type="reset" class="btn btn-success btn-100">重置</button>      
            <a href="{{ url('admin/activity/group') }}">
              <button type="button" class="btn btn-success btn-100" id="cancel_addUser">取消</button>
            </a>         
          </div>
        </div>
      </div>
    </form>
  </div>
</div>
</div>
</section>

@endsection
