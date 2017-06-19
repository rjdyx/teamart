@extends('fx.admin.layouts.app')

@section('title')
编辑代理商角色
@endsection

@section('t1')
用户管理
@endsection

@section('css')
@endsection

@section('script')
    @parent
    <script>
      $(function () {
        var form = document.forms['parterForm']
        $(form).on('submit', function () {
          return submitForm()
        })
        $('#name').on('blur input', function () {
          validname('name', '用户名', $(this).val(), 'parter')
        })
        $('#scale').on('blur input', function () {
          validscale('scale', $(this).val())
        })
        $('#desc').on('blur input', function () {
          validdesc('desc', '角色描述', $(this).val())
        })
        function submitForm() {
          var name = form['name']
          var scale = form['scale']
          var desc = form['desc']
          if (!validname('name', '用户名', $(this).val(), 'parter')) {
            return false
          }
          if (!validscale('scale', scale.value)) {
            return false
          }
          if (!validdesc('desc', '角色描述', desc.value)) {
            return false
          }
          return true
        }
      })
    </script>
@endsection

@section('content')
  <section class="content">
    <div class="row">
      <!-- 编辑代理商角色 -->
      <div class="col-xs-12">
        <div class="box box-success">
          <div class="box-header with-border">
            <h3 class="box-title">编辑代理商角色</h3>
          </div>
          <!-- /.box-header -->
          <!-- form start -->
          <form class="form-horizontal" action="{{url('admin/user/agentrole')}}/{{$data->id}}" method="POST" name="parterForm">
          {{ csrf_field() }}
          <input type="hidden" value="PUT" name="_method">
          <input type="hidden" value="{{$data->id}}" name="id" id="id">
            <div class="box-body">
              <div class="form-group">
                <label for="name" class="col-sm-3 control-label"><i style="color:red;">*</i> 分销角色名称</label>

                <div class="col-sm-4">
                  <input type="text" name="name" class="form-control" id="name" placeholder="请输入分销角色名称，不超过50字符" value="{{$data->name}}">
                </div>
                <span class="col-sm-4 text-danger form_error" id="name_txt"></span>
              </div>
              <div class="form-group">
                <label for="scale" class="col-sm-3 control-label"><i style="color:red;">*</i>分销比例</label>

                <div class="col-sm-4">
                  <input type="text" class="form-control" id="scale" placeholder="请输入范围在0 ~ 1的数，保留两位小数" name='scale' value="{{$data->scale}}">
                </div>
                <span class="col-sm-4 text-danger form_error" id="scale_txt"></span>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="desc">描述</label>
                <div class="col-sm-4">
                  <textarea class="form-control" rows="3" name="desc" id="desc" placeholder="请输入角色描述 ...">{{$data->desc}}</textarea>
                </div>
                <span class="col-sm-4 text-danger form_error" id="desc_txt"></span>
              </div>
              <div class="form-group">
                <div class="col-sm-offset-3 col-sm-10">
                  <button type="submit" class="btn btn-success btn-100">确认</button>
                  <button type="reset" class="btn btn-success btn-100">重置</button>
                  <a href="{{ url('admin/user/agentrole') }}"><button type="button" class="btn btn-success btn-100" id="cancel_addAgent">取消</button></a>
                </div>
              </div>
            </div>
            <!-- /.box-body -->
          </form>
        </div>
      </div>
      <!-- /编辑代理商角色 -->
    </div>
  </section>
@endsection

