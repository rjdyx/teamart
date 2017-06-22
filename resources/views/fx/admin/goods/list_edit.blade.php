@extends('fx.admin.layouts.app')
@section('title')编辑商品@endsection
@section('t1')商品管理@endsection
@section('css')
@endsection
@section('script')
    @parent
    <script src="{{url('ueditor/ueditor.config.js')}}"></script>
    <script src="{{url('ueditor/ueditor.all.min.js')}}"></script>
    <script src="{{url('ueditor/lang/zh-cn/zh-cn.js')}}"></script>
    <script src="{{url('admin/js/uploads.js')}}"></script>
    <script>
      //实例化编辑器
      //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
      $(function () {
        var ue = UE.getEditor('editor');
        imagePathFormat='/upload/descs/'; 
        datepicker.datepicker()
        var form = document.forms['listForm']
        $(form).on('submit', function () {
          return submitForm()
        })
        $('#category_id').on('change', function () {
          _valid.ness('category_id', '商品分类', $(this).val())
        })
        $('#group_id').on('change', function () {
          _valid.ness('group_id', '商品组', $(this).val())
        })
        $('#brand_id').on('change', function () {
          _valid.ness('brand_id', '商品品牌', $(this).val())
        })
        $('#spec_id').on('change', function () {
          _valid.ness('spec_id', '商品规格', $(this).val())
        })
        $('#name').on('blur input', function () {
          _valid.name('name', '商品名称', $(this).val(), 'product')
        })
        $('#desc').on('blur input', function () {
          _valid.desc('desc', '商品描述', $(this).val(), 50, true)
        })
        $('#price_raw').on('blur input', function () {
          _valid.number('price_raw', '原价', $(this).val())
        })
        $('#price').on('blur input', function () {
          _valid.number('price', '现价', $(this).val())
        })
        $('#delivery_price').on('blur input', function () {
          _valid.number('delivery_price', '邮费', $(this).val())
        })
        $('#stock').on('blur input', function () {
          _valid.number('stock', '库存', $(this).val())
        })
        $('#low_stock').on('blur input', function () {
          _valid.number('low_stock', '低库存', $(this).val())
        })
        $('#origin').on('blur input', function () {
          _valid.desc('origin', '商品产地', $(this).val(), 50, true)
        })
        $('#effect').on('blur input', function () {
          _valid.desc('effect', '商品作用', $(this).val(), 50, true)
        })
        $('#date').on('blur input', function () {
          _valid.birth_date('date', '生产日期', $(this).val(), true)
        })
        $('#state').on('change', function () {
          _valid.ness('state', '商品状态', $(this).val())
        })
        $('#grade').on('change', function () {
          _valid.ness('grade', '商品积分兑换', $(this).val())
        })
        function submitForm() {
          var category_id = form['category_id']
          var group_id = form['group_id']
          var brand_id = form['brand_id']
          var spec_id = form['spec_id']
          var name = form['name']
          var desc = form['desc']
          var price_raw = form['price_raw']
          var price = form['price']
          var delivery_price = form['delivery_price']
          var stock = form['stock']
          var low_stock = form['low_stock']
          var origin = form['origin']
          var effect = form['effect']
          var date = form['date']
          var state = form['state']
          var grade = form['grade']
          var imgs = form['imgs']
          if (!_valid.ness('category_id', '商品分类', category_id.value)) {
            return false
          }
          if (!_valid.ness('group_id', '商品组', group_id.value)) {
            return false
          }
          if (!_valid.ness('brand_id', '商品品牌', brand_id.value)) {
            return false
          }
          if (!_valid.ness('spec_id', '商品规格', spec_id.value)) {
            return false
          }
          if (!_valid.name('name', '商品名称', name.value, 'product')) {
            return false
          }
          if (!_valid.desc('desc', '商品描述', desc.value, 50, true)) {
            return false
          }
          if (!_valid.number('price_raw', '原价', price_raw.value)) {
            return false
          }
          if (!_valid.number('price', '现价', price.value)) {
            return false
          }
          if (!_valid.number('delivery_price', '邮费', delivery_price.value)) {
            return false
          }
          if (!_valid.number('stock', '库存', stock.value)) {
            return false
          }
          if (!_valid.number('low_stock', '低库存', low_stock.value)) {
            return false
          }
          if (!_valid.desc('origin', '商品产地', origin.value, 50, true)) {
            return false
          }
          if (!_valid.desc('effect', '商品作用', effect.value, 50, true)) {
            return false
          }
          if (!_valid.birth_date('date', '生产日期', date.value, true)) {
            return false
          }
          if (!_valid.ness('state', '商品状态', state.value)) {
            return false
          }
          if (!_valid.ness('grade', '商品积分兑换', grade.value)) {
            return false
          }
          if (imgs.length) {
            var arr = []
            for (let i = 0; i < imgs.length; i++) {
              if (imgs[i].files[0]) {
                if (!_valid.img('imgs', imgs[i].files[0])) {
                  return false
                }
                arr.push(imgs[i].files[0])
              }
            }
            if (arr.length == 0) {
              $('#img_txt').text('至少要上传一张商品图片')
              return false
            }
          } else {
            if (imgs.files.length == 0) {
              $('#img_txt').text('至少要上传一张商品图片')
              return false
            }
          }
          return true
        } 
      })
    </script>
@endsection
@section('content')
    <section class="content">
      <div class="row">
        <!-- 编辑商品 -->
        <div class="col-xs-12">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">编辑商品</h3>
            </div>
            <form class="form-horizontal" action="{{url('admin/goods/list')}}/{{$data->id}}" method="POST" name="listForm" enctype="multipart/form-data">
              {{ csrf_field() }}
              <input type="hidden" value="PUT" name="_method">
              <input type="hidden" value="{{$data->id}}" name="id" id="id">
              <input type="hidden" value="" name="dels" id="dels">
              <div class="box-body">
                <div class="form-group">
                  <label class="col-sm-3 control-label"><i style="color:red;">*</i>商品分类</label>
                  <div class="col-sm-4">
                    <select name="category_id" class="form-control" id="category_id">
                      <option value="">-请选择商品分类-</option>
                      @foreach($categorys as $category)
                        <option value="{{$category->id}}" @if($category->id == $data->category_id) selected @endif >{{$category->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="category_id_txt"></span>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label"><i style="color:red;">*</i>商品组</label>
                  <div class="col-sm-4">
                    <select name="group_id" class="form-control" id="group_id">
                      <option value="">-请选择商品组-</option>
                      @foreach($groups as $group)
                        <option value="{{$group->id}}" @if($group->id == $data->group_id) selected @endif >{{$group->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="group_id_txt"></span>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label"><i style="color:red;">*</i>商品品牌</label>
                  <div class="col-sm-4">
                    <select name="brand_id" class="form-control" id="brand_id">
                      <option value="">-请选择商品品牌-</option>
                      @foreach($brands as $brand)
                        <option value="{{$brand->id}}" @if($brand->id == $data->brand_id) selected @endif >{{$brand->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="brand_id_txt"></span>
                </div>
               <div class="form-group">
                  <label class="col-sm-3 control-label"><i style="color:red;">*</i>商品规格</label>
                  <div class="col-sm-4">
                    <select name="spec_id" class="form-control" id="spec_id">
                      <option value="">-请选择商品规格-</option>
                      @foreach($specs as $spec)
                        <option value="{{$spec->id}}" @if($spec->id == $data->spec_id) selected @endif >{{$spec->name}}</option>
                      @endforeach
                    </select>
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="spec_id_txt"></span>
                </div>
                <div class="form-group">
                  <label for="name" class="col-sm-3 control-label"><i style="color:red;">*</i>商品名称</label>
                  <div class="col-sm-4">
                    <input type="text" name="name" class="form-control" id="name" placeholder="请输入商品名称" value="{{$data->name}}">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="name_txt"></span>
                </div>
                <div class="form-group">
                  <label for="desc" class="col-sm-3 control-label"><i style="color:red;">*</i>商品描述</label>
                  <div class="col-sm-4">
                    <input type="text" name="desc" class="form-control" id="desc" placeholder="请输入商品描述" value="{{$data->desc}}">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="desc_txt"></span>
                </div>
                <div class="form-group">
                  <label for="price_raw" class="col-sm-3 control-label"><i style="color:red;">*</i>原价</label>
                  <div class="col-sm-4">
                    <input type="text" name="price_raw" class="form-control J_FloatNum" id="price_raw" placeholder="请输入商品原价" value="{{$data->price_raw}}">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="price_raw_txt"></span>
                </div>
                <div class="form-group">
                  <label for="price" class="col-sm-3 control-label"><i style="color:red;">*</i>现价</label>
                  <div class="col-sm-4">
                    <input type="text" name="price" class="form-control J_FloatNum" id="price" placeholder="请输入商品现价" value="{{$data->price}}">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="price_txt"></span>
                </div>
                <div class="form-group">
                  <label for="delivery_price" class="col-sm-3 control-label"><i style="color:red;">*</i>邮费(0免邮)</label>
                  <div class="col-sm-4">
                    <input type="text" name="delivery_price" class="form-control J_FloatNum" id="delivery_price" placeholder="请输入商品快递邮费" value="{{$data->delivery_price}}">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="delivery_price_txt"></span>
                </div>
                <div class="form-group">
                  <label for="stock" class="col-sm-3 control-label"><i style="color:red;">*</i>库存</label>
                  <div class="col-sm-4">
                    <input type="text" name="stock" class="form-control J_IntNum" id="stock" placeholder="请输入商品库存" value="{{$data->stock}}">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="stock_txt"></span>
                </div>
                <div class="form-group">
                  <label for="low_stock" class="col-sm-3 control-label"><i style="color:red;">*</i>低库存</label>
                  <div class="col-sm-4">
                    <input type="text" name="low_stock" class="form-control J_IntNum" id="low_stock" placeholder="请输入商品低库存" value="{{$data->low_stock}}">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="low_stock_txt"></span>
                </div>
                <div class="form-group">
                  <label for="origin" class="col-sm-3 control-label"><i style="color:red;">*</i>商品产地</label>
                  <div class="col-sm-4">
                    <input type="text" name="origin" class="form-control" id="origin" placeholder="请输入商品产地" value="{{$data->origin}}">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="origin_txt"></span>
                </div>
                <div class="form-group">
                  <label for="effect" class="col-sm-3 control-label"><i style="color:red;">*</i>商品作用</label>
                  <div class="col-sm-4">
                    <input type="text" name="effect" class="form-control" id="effect" placeholder="请输入商品作用" value="{{$data->effect}}">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="effect_txt"></span>
                </div>
                <div class="form-group">
                  <label for="datepicker" class="col-sm-3 control-label"><i style="color:red;">*</i>生产日期</label>
                  <div class="col-sm-4">
                    <div class="input-group">
                      <input type="text" name="date" class="form-control pull-right" id="datepicker" value="{{$data->date}}">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                    </div>
                    <span class="col-sm-4 text-danger form_error" id="date_txt"></span>
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i>商品状态</label>
                  <div class="col-sm-2">
                    <input type="radio" name="state" @if ($data->state)checked @endif  value="1">开启(有货)
                  </div>
                  <div class="col-sm-2">
                    <input type="radio" name="state" @if (!$data->state)checked @endif value="0">关闭(缺货)
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="state_txt"></span>
                </div>
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-3 control-label"><i style="color:red;">*</i>商品积分兑换</label>
                  <div class="col-sm-2">
                    <input type="radio" name="grade" @if ($data->grade)checked @endif  value="1">是
                  </div>
                  <div class="col-sm-2">
                    <input type="radio" name="grade"  @if (!$data->grade)checked @endif  value="0">否
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="grade_txt"></span>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label"><i style="color:red;">*</i>商品图片</label>
                  <div class="col-sm-4 upload_list">
                    @if ($imgs)
                      @foreach($imgs as $k => $img)
                      <div class="upload_box pull-left ml-10 mt-10">
                        <img class="pull-left upload_img" src="{{url('')}}/{{$img->img}}">
                        <label for="img{{$k + 1}}" class="upload pull-left hidden">
                          <i class="glyphicon glyphicon-plus"></i>
                        </label>
                        <label class="btn btn-primary pull-left ml-10" for="img{{$k + 1}}">修改</label>
                        <div class="btn btn-danger pull-left ml-10 mt-10 J_removes">删除</div>
                        <input type="file" name="imgs[]" id="img{{$k + 1}}" data-id="{{$img->id}}" class="form-control invisible J_imgs" accept="image/jpeg,image/jpg,image/png">
                      </div>
                      @endforeach
                      @if (count($imgs) + 1 < 5)
                      <div class="upload_box pull-left ml-10 mt-10">
                        <label for="img{{count($imgs) + 1}}" class="upload pull-left">
                          <i class="glyphicon glyphicon-plus"></i>
                        </label>
                        <label class="btn btn-primary pull-left ml-10 invisible" for="img{{count($imgs) + 1}}">修改</label>
                        <div class="btn btn-danger pull-left ml-10 mt-10 invisible J_removes">删除</div>
                        <input type="file" name="imgs[]" id="img{{count($imgs) + 1}}" class="form-control invisible J_imgs" accept="image/jpeg,image/jpg,image/png">
                      </div>
                      @endif
                    @else
                      <div class="upload_box pull-left ml-10 mt-10">
                        <label for="img1" class="upload pull-left">
                          <i class="glyphicon glyphicon-plus"></i>
                        </label>
                        <label class="btn btn-primary pull-left invisible ml-10" for="img1">修改</label>
                        <div class="btn btn-danger pull-left invisible ml-10 mt-10 J_removes">删除</div>
                        <input type="file" name="imgs[]" id="img1" class="form-control invisible J_imgs" accept="image/jpeg,image/jpg,image/png">
                      </div>
                    @endif
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="imgs_txt"></span>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label">详情图描述</label>
                  <div class="col-sm-5">
                    <script id="editor" type="text/plain"  name="img_desc" 
                    style="width:1024px;height:400px;border:1px solid #3DCDB4;">
                    @if(isset($imgdesc->desc)) {{$imgdesc->desc}} @endif
                    </script>
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

