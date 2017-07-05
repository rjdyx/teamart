@extends('fx.admin.layouts.app')
@section('title')新增积分商品@endsection
@section('t1')促销管理@endsection
@section('css')
@endsection
@section('script')
    @parent
    <script>
      $(function () {
        var form = document.forms['brandForm']
        $(form).on('submit', function () {
          return submitForm()
        })
        $('#name').on('blur input', function () {
          _valid.name('name', '品牌名称', $(this).val(), 'brand')
        })
        $('#desc').on('blur input', function () {
          _valid.desc('desc', '品牌描述', $(this).val())
        })
        function submitForm() {
          var name = form['name']
          var desc = form['desc']
          var img = form['img']
          if (!_valid.name('name', '品牌名称', name.value, 'brand')) {
            return false
          }
          if (!_valid.desc('desc', '品牌描述', desc.value)) {
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
        <div class="col-xs-12">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">新增积分商品</h3>
            </div>

            <form class="form-horizontal" action="{{url('admin/goods/brand')}}" method="POST" name="brandForm" enctype="multipart/form-data">
              {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="name" class="col-sm-3 control-label"><i style="color:red;">*</i>商品分类</label>
                  <div class="col-sm-4">
                    <select name="" id=""  class="form-control">
                        <option value="">-请选择商品分类-</option>
                    </select>
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="name_txt"></span>
                </div>
                <div class="form-group">
                  <label for="desc" class="col-sm-3 control-label">商品</label>
                  <div class="col-sm-4">
                        <span><input type="checkbox" value="id">商品1</span>
                        <span><input type="checkbox" value="id">商品2</span>
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="desc_txt"></span>
                </div>
                <div class="form-group">
                  <label for="desc" class="col-sm-3 control-label"></label>
                  <div class="col-sm-4">
                    全选 <input type="checkbox" value="id">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="desc_txt"></span>
                </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-10">
                    <button type="submit" class="btn btn-success btn-100">确认</button>
                    <button type="reset" class="btn btn-success btn-100">重置</button>
                    <a href="{{ url('admin/goods/brnad') }}"><button type="button" class="btn btn-success btn-100" id="cancel_addAgent">取消</button></a>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
@endsection

