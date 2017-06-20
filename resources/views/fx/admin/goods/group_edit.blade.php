@extends('fx.admin.layouts.app')
@section('title')新增商品组@endsection
@section('t1')商品管理@endsection
@section('css')@endsection
@section('script')
    @parent
    <script>
      $(function () {
        var form = document.forms['groupForm']
        $(form).on('submit', function () {
          return submitForm()
        })
        $('#category_id').on('change', function () {
          ness('category_id', '商品分类', $(this).val())
        })
        $('#name').on('blur input', function () {
          validname('name', '商品组名称', $(this).val(), 'product_group')
        })
        $('#desc').on('blur input', function () {
          validdesc('desc', '商品组描述', $(this).val())
        })
        function submitForm() {
          var category_id = form['category_id']
          var name = form['name']
          var desc = form['desc']
          if (!ness('category_id', '商品分类', category_id.value)) {
            return false
          }
          if (!validname('name', '分类名称', name.value, 'product_category')) {
            return false
          }
          if (!validdesc('desc', '分类描述', desc.value)) {
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
        <!-- 新增商品组 -->
        <div class="col-xs-12">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">新增商品组</h3>
            </div>
            <form class="form-horizontal" action="{{url('admin/goods/group')}}/{{$data->id}}" method="POST" name="groupForm">
              {{ csrf_field() }}
              <input type="hidden" value="PUT" name="_method">
              <input type="hidden" value="{{$data->id}}" name="id" id="id">
              <div class="box-body">
                <div class="form-group">
                  <label for="category_id" class="col-sm-3 control-label"><i style="color:red;">*</i>商品分类</label>
                  <div class="col-sm-4">
                    <select name="category_id" class="form-control" id="category_id">
                      <option value="">-请选择商品分类-</option>
                      @foreach($selects as $select)
                        <option value="{{$select->id}}" @if ($select->id == $data->id) selected @endif>{{$select->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="category_id_txt"></span>
                </div>
                <div class="form-group">
                  <label for="name" class="col-sm-3 control-label"><i style="color:red;">*</i>商品组名称</label>
                  <div class="col-sm-4">
                    <input type="text" name="name" class="form-control" id="name" placeholder="请输入商品组名称">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="name_txt"></span>
                </div>
                <div class="form-group">
                  <label for="desc" class="col-sm-3 control-label">商品组描述</label>
                  <div class="col-sm-4">
                    <input type="text" name="desc" class="form-control" id="desc" placeholder="请输入商品组描述">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="desc_txt"></span>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-10">
                    <button type="submit" class="btn btn-success btn-100">确认</button>
                    <button type="reset" class="btn btn-success btn-100">重置</button>
                    <a href="{{ url('admin/goods/group') }}"><button type="button" class="btn btn-success btn-100" id="cancel_addAgent">取消</button></a>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
@endsection

