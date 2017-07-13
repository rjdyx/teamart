@extends('fx.admin.layouts.app')

@section('t1')
系统管理
@endsection
@section('title')
店铺设置
@endsection

@section('css')

@endsection

@section('script')
    @parent
    <script src="{{url('admin/js/upload.js')}}"></script>
    <script src="{{url('admin/js/uploads.js')}}"></script>
    <script>
      $(function () {
        var form = document.forms['shopForm']
        $(form).on('submit', function () {
          return submitForm()
        })
        $('#name').on('blur input', function () {
          _valid.title('name', '网站名称', $(this).val(), 2, false)
        })
        $('#email').on('blur input', function () {
          _valid.email('email', $(this).val(), false)
        })
        $('#phone').on('blur input', function () {
          _valid.phone('phone', $(this).val())
        })
        $('#free').on('blur input', function () {
          _valid.number('free', '免邮金额', $(this).val(), false)
        })
        $('#record').on('blur input', function () {
          _valid.desc('record', '备案号', $(this).val(), 20, false)
        })
        function submitForm() {
          var name = form['name']
          var email = form['email']
          var phone = form['phone']
          var free = form['free']
          var record = form['record']
          if (!_valid.title('name', '网站名称', name.value, 2, false)) {
            return false
          }
          if (!_valid.email('email', email.value, false)) {
            return false
          }
          if (!_valid.phone('phone', phone.value)) {
            return false
          }
          if (!_valid.number('free', '免邮金额', free.value, false)) {
            return false
          }
          if (!_valid.desc('record', '备案号', record.value, 20, false)) {
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
              
              <form action="{{url('admin/system/shop')}}/{{$shop->id}}" method="POST" class="form-horizontal" name="shopForm" enctype="multipart/form-data">
                {{ csrf_field() }}
                <input type="hidden" value="PUT" name="_method">
                <input type="hidden" value="" name="del" id="del">
                <input type="hidden" value="" name="dels" id="dels">
                <div class="box-body">
                  <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">网站名称</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="name" placeholder="请输入商店名称" name="name" value="{{$shop->name}}">
                    </div>
                    <span class="col-sm-4 text-danger form_error" id="name_txt"></span>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">关键字</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" placeholder="请输入关键字 (多个以，隔开)" name="keywords" value="{{$shop->keywords}}">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="email" class="col-sm-2 control-label">意见邮箱</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="email" placeholder="请输入联系email" name="email" value="{{$shop->email}}">
                    </div>
                    <span class="col-sm-4 text-danger form_error" id="email_txt"></span>
                  </div>
                  <div class="form-group">
                    <label for="phone" class="col-sm-2 control-label">热线电话</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="phone" placeholder="请输入联系电话" name="phone" value="{{$shop->phone}}">
                    </div>
                    <span class="col-sm-4 text-danger form_error" id="phone_txt"></span>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-2 control-label">验证码</label>
                    <label class="col-sm-2 gender_label control-label">
                      <input type="radio" name="verify_state" id="gender_female" value="0" @if($shop->verify_state===0)checked="checked"@endif>关闭
                    </label>
                    <label class="col-sm-2 gender_label control-label">
                      <input type="radio" name="verify_state" id="gender_male" value="1" @if($shop->verify_state===1)checked="checked"@endif >打开
                    </label>
                    <span class="col-sm-4 text-danger form_error" id="verify_state_txt"></span>
                  </div>
                  <div class="form-group">
                    <label for="free" class="col-sm-2 control-label">免邮金额</label>
                    <div class="col-sm-6">
                      <input type="number" class="form-control J_FloatNum" id="free" placeholder="请输入免邮金额" name="free" value="{{$shop->free}}">
                    </div>
                    <span class="col-sm-4 text-danger form_error" id="free_txt"></span>
                  </div>
                  <div class="form-group">
                    <label for="record" class="col-sm-2 control-label">备案号</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="record" placeholder="请输入备案号" name="record" value="{{$shop->record}}">
                    </div>
                    <span class="col-sm-4 text-danger form_error" id="record_txt"></span>
                  </div>
                  <div class="form-group">
                    <label for="delivery_id" class="col-sm-2 control-label">物流商户ID</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="delivery_id" placeholder="请输入商户ID" name="delivery_id" value="{{$shop->delivery_id}}">
                    </div>
                    <span class="col-sm-4 text-danger form_error" id="delivery_id_txt"></span>
                  </div>
                  <div class="form-group">
                    <label for="delivery_id" class="col-sm-2 control-label">物流密匙Key</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="delivery_key" placeholder="请输入密匙" name="delivery_key" value="{{$shop->delivery_key}}">
                    </div>
                    <span class="col-sm-4 text-danger form_error" id="delivery_key_txt"></span>
                  </div>
                  <div class="form-group">
                    <label for="delivery_id" class="col-sm-2 control-label">客服QQ</label>
                    <div class="col-sm-6">
                      <input type="text" class="form-control" id="qq" placeholder="请输入QQ号" name="qq" value="{{$shop->qq}}">
                    </div>
                    <span class="col-sm-4 text-danger form_error" id="delivery_key_txt"></span>
                  </div>
                  <!-- logo -->
                  <div class="form-group">
                    <label class="col-sm-2 control-label">logo</label>
                    <div class="col-sm-4">
                      <div class="upload_single ml-10">
                        @if ($shop->logo) 
                          <img class="pull-left upload_img" src="{{url('')}}/{{$shop->logo}}">
                          <label for="img" class="upload pull-left hidden">
                            <i class="glyphicon glyphicon-plus"></i>
                          </label>
                          <label class="btn btn-primary pull-left ml-10" for="img">修改</label>
                          <div class="btn btn-danger pull-left ml-10 J_remove">删除</div>
                          <input type="file" name="img" id="img" class="invisible form-control J_img" accept="image/jpeg,image/jpg,image/png">
                        @else
                          <label for="img" class="upload pull-left">
                            <i class="glyphicon glyphicon-plus"></i>
                          </label>
                          <label class="btn btn-primary pull-left ml-10 invisible" for="img">修改</label>
                          <div class="btn btn-danger pull-left ml-10 invisible J_remove">删除</div>
                          <input type="file" name="img" id="img" class="invisible form-control J_img" accept="image/jpeg,image/jpg,image/png">
                        @endif
                      </div>
                    </div>
                    <span class="col-sm-4 text-danger form_error" id="img_txt"></span>
                  </div>
                  <!-- 轮播图 -->
                   <div class="form-group">
                  <label class="col-sm-2 control-label">轮播图</label>
                  <div class="col-sm-4 upload_list">
                    @if ($imgs)
                      @foreach($imgs as $k => $img)
                      <div class="upload_box pull-left ml-10 mt-10">
                        <img class="pull-left upload_img" src="{{url('')}}/{{$img}}">
                        <label for="img{{$k + 1}}" class="upload pull-left hidden">
                          <i class="glyphicon glyphicon-plus"></i>
                        </label>
                        <label class="btn btn-primary pull-left ml-10" for="img{{$k + 1}}">修改</label>
                        <div class="btn btn-danger pull-left ml-10 mt-10 J_removes">删除</div>
                        <input type="file" name="imgs[]" id="img{{$k + 1}}" data-id="{{$k + 1}}" class="form-control invisible J_imgs" accept="image/jpeg,image/jpg,image/png">
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
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-success btn-100">确认</button>
                      <button type="reset" class="btn btn-success btn-100">重置</button>
                    </div>
                  </div>
                </div>
                <!-- /.box-body -->
              </form>
            </div>
          </div>
          <!-- /新增代理商角色 -->
        </div>
      </section>
      <!-- /.content -->

@endsection
