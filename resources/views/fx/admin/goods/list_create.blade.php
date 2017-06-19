@extends('fx.admin.layouts.app')
@section('title')新增商品@endsection
@section('t1')商品管理@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{url('admin/js/datepicker/datepicker3.css')}}">
@endsection
@section('script')
    @parent
    <script src="{{url('ueditor/ueditor.config.js')}}"></script>
    <script src="{{url('ueditor/ueditor.all.min.js')}}"></script>
    <script src="{{url('ueditor/lang/zh-cn/zh-cn.js')}}"></script>
    <script src="{{url('admin/js/datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{url('admin/js/datepicker/locales/bootstrap-datepicker.zh-CN.js')}}"></script>
    <script>
        $('#datepicker').datepicker({
          language: 'zh-CN',
          format: 'yyyy-mm-dd'
        });
        //实例化编辑器
        //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
        var ue = UE.getEditor('editor');
        imagePathFormat='/upload/descs/'; 
    </script>
@endsection
@section('content')
    <section class="content">
      <div class="row">
        <!-- 新增商品 -->
        <div class="col-xs-12">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">新增商品</h3>
            </div>
            <form class="form-horizontal" action="{{url('admin/goods/list')}}" method="POST">
              {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i>商品分类</label>
                  <div class="col-sm-4">
                    <select name="category_id" class="form-control" >
                      <option value="">-请选择商品分类-</option>
                      @foreach($categorys as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i>商品组</label>
                  <div class="col-sm-4">
                    <select name="group_id" class="form-control" >
                      <option value="">-请选择商品组-</option>
                      @foreach($groups as $group)
                        <option value="{{$group->id}}">{{$group->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i>商品品牌</label>
                  <div class="col-sm-4">
                    <select name="brand_id" class="form-control" >
                      <option value="">-请选择商品品牌-</option>
                      @foreach($brands as $brand)
                        <option value="{{$brand->id}}">{{$brand->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
               <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i>商品规格</label>
                  <div class="col-sm-4">
                    <select name="spec_id" class="form-control" >
                      <option value="">-请选择商品规格-</option>
                      @foreach($specs as $spec)
                        <option value="{{$spec->id}}">{{$spec->name}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i>商品名称</label>
                  <div class="col-sm-4">
                    <input type="text" name="name" class="form-control" id="inputEmail3" placeholder="请输入商品名称">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i>商品描述</label>
                  <div class="col-sm-4">
                    <input type="text" name="desc" class="form-control" id="inputEmail3" placeholder="请输入商品描述">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i>原价</label>
                  <div class="col-sm-4">
                    <input type="text" name="price_raw" class="form-control" id="inputEmail3" placeholder="请输入商品原价" value="0.00">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i>现价</label>
                  <div class="col-sm-4">
                    <input type="text" name="price" class="form-control" id="inputEmail3" placeholder="请输入商品现价">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i>邮费(0免邮)</label>
                  <div class="col-sm-4">
                    <input type="text" name="delivery_price" class="form-control" id="inputEmail3" placeholder="请输入商品快递邮费" value="0.00">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i>库存</label>
                  <div class="col-sm-4">
                    <input type="text" name="stock" class="form-control" id="inputEmail3" placeholder="请输入商品库存" value="1">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i>低库存</label>
                  <div class="col-sm-4">
                    <input type="text" name="low_stock" class="form-control" id="inputEmail3" placeholder="请输入商品低库存" value="1">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i>商品产地</label>
                  <div class="col-sm-4">
                    <input type="text" name="origin" class="form-control" id="inputEmail3" placeholder="请输入商品产地" value="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i>商品作用</label>
                  <div class="col-sm-4">
                    <input type="text" name="effect" class="form-control" id="inputEmail3" placeholder="请输入商品作用" value="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i>生产日期</label>
                  <div class="col-sm-4">
                    <div class="input-group date">
                      <input type="text" name="date" class="form-control pull-right" id="datepicker">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i>商品状态</label>
                  <div class="col-sm-2">
                    <input type="radio" name="state" checked  value="1">开启(有货)
                  </div>
                  <div class="col-sm-2">
                    <input type="radio" name="state" value="0">关闭(缺货)
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i>商品积分兑换</label>
                  <div class="col-sm-2">
                    <input type="radio" name="grade" checked  value="1">是
                  </div>
                  <div class="col-sm-2">
                    <input type="radio" name="grade" value="0">否
                  </div>
                </div>
                <!-- 此处4张图片上传 待完成... -->
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i>商品图片</label>
                  <div class="col-sm-4">
                    此处4张图片上传 待完成...
                  </div>
                </div>

                <!-- 此处4张图片上传 待完成... -->
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">详情图描述</label>
                  <div class="col-sm-5">
                    <script id="editor" type="text/plain"  name="img_desc" 
                    style="width:1024px;height:400px;border:1px solid #3DCDB4;"></script>
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-10">
                    <button type="submit" class="btn btn-success btn-100">确认</button>
                    <button type="reset" class="btn btn-success btn-100">重置</button>
                    <a href="{{ url('admin/goods/list') }}"><button type="button" class="btn btn-success btn-100" id="cancel_addAgent">取消</button></a>
                  </div>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </section>
@endsection

