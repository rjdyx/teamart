@extends('fx.admin.layouts.app')
@section('title')编辑代理商@endsection
@section('t1')用户管理@endsection
@section('css')
@endsection
@section('script')
    @parent
    <script>
      $(function () {
        datepicker();
        var form = document.forms['userForm']
        $(form).on('submit', function () {
          return submitForm()
        })
        function submitForm() {
          var name = form['name']
          var email = form['email']
          var parter_id = form['parter_id']
          var gender = form['gender']
          var password = form['password']
          var repassword = form['repassword']
          var phone = form['phone']
          var realname = form['realname']
          var birth_date = form['birth_date']
          if (!_valid.name('name', '用户名', name.value, 'user')) {
            return false
          }
          if (!_valid.email('email', email.value)) {
            return false
          }
          if (!_valid.ness('parter_id', '代理商角色', parter_id.value)) {
            return false
          }
          if (!_valid.ness('gender', '性别', gender.value)) {
            return false
          }
          // if (!_valid.password('password', password.value, false)) {
          //   return false
          // }
          // if (!_valid.repassword('repassword', repassword.value, false)) {
          //   return false
          // }
          if (!_valid.phone('phone', phone.value)) {
            return false
          }
          if (!_valid.realname('realname', realname.value)) {
            return false
          }
          if (!_valid.birth_date('birth_date', '出生日期', birth_date.value)) {
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
        <!-- 编辑代理商 -->
        <div class="col-xs-12">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">编辑代理商</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{url('admin/user/agent')}}/{{$data->id}}" method="POST" name="userForm">
              {{ csrf_field() }}
              <input type="hidden" value="PUT" name="_method">
              <input type="hidden" value="{{$data->id}}" name="id" id="id">
              <div class="box-body">
                <div class="form-group">
                  <label for="name" class="col-sm-3 control-label"><i style="color:red;">*</i>用户名</label>
                  <div class="col-sm-4">
                    <input type="text" name="name" class="form-control" id="name" placeholder="请输入用户名" value="{{$data->name}}" onblur="_valid.name('name', '用户名', this.value, 'user')" oninput="_valid.name('name', '用户名', this.value, 'user')">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="name_txt"></span>
                </div>
                <div class="form-group">
                  <label for="realname" class="col-sm-3 control-label">姓名</label>
                  <div class="col-sm-4">
                    <input type="text" name="realname" class="form-control" id="realname" placeholder="请输入姓名" value="{{$data->realname}}" oninput="_valid.realname('realname', this.value)" onblur="_valid.realname('realname', this.value)">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="realname_txt"></span>
                </div>
                <div class="form-group">
                  <label for="email" class="col-sm-3 control-label"><i style="color:red;">*</i>邮箱</label>
                  <div class="col-sm-4">
                    <input type="email" name="email" class="form-control" id="email" placeholder="请输入邮箱" value="{{$data->email}}" onblur="_valid.email('email', this.value)" oninput="_valid.email('email', this.value)">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="email_txt"></span>
                </div>
                <div class="form-group">
                  <label for="phone" class="col-sm-3 control-label">手机</label>
                  <div class="col-sm-4">
                    <input type="text" name="phone" class="form-control" id="phone" placeholder="请输入手机号" value="{{$data->phone}}" oninput="_valid.phone('phone', this.value)" onblur="_valid.phone('phone', this.value)">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="phone_txt"></span>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label"><i style="color:red;">*</i>代理商角色</label>
                  <div class="col-sm-4">
                    <select class="form-control" name="parter_id" id="parter_id" onchange="ness('parter_id', '代理商角色', this.value)">
                      <option value="">请选择代理商角色</option>
                      @foreach($selects as $select)
                      <option value="{{$select->id}}" 
                      @if($data->parter_id == $select->id) selected @endif >
                      {{$select->name}} ({{$select->scale}})
                      </option>
                      @endforeach
                    </select>
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="parter_id_txt"></span>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label"><i style="color:red;">*</i>性别</label>
                  <div class="col-sm-4">
                    <label class="col-sm-2 gender_label control-label">
                    <input type="radio" name="gender" id="gender_male" value="0" @if(!$data->gender) checked="checked" @endif>男
                    </label>
                    <label class="col-sm-2 gender_label control-label">
                      <input type="radio" name="gender" id="gender_female" value="1" @if($data->gender) checked="checked" @endif>女
                    </label>
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="gender_txt"></span>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label" for="datepicker">出生日期</label>
                  <div class="col-sm-4">
                    <div class="input-group date">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" value="{{$data->birth_date}}" class="form-control pull-right" id="datepicker" name="birth_date" oninput="_valid.birth_date('birth_date', '出生日期', this.value)">
                    </div>
                    <!-- /.input group -->
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="birth_date_txt"></span>
                </div>
                <!-- <div class="form-group">
                  <label for="password" class="col-sm-3 control-label">登录密码</label>
                  <div class="col-sm-4">
                    <input type="password" name="password" class="form-control" id="password" placeholder="不输入密码则不修改" onblur="_valid.password('password', this.value, false)" oninput="_valid.password('password', this.value, false)">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="password_txt"></span>
                </div>
                <div class="form-group">
                  <label for="repassword" class="col-sm-3 control-label">确认密码</label>
                  <div class="col-sm-4">
                    <input type="password" class="form-control" id="repassword" placeholder="若登录密码未输入，则确认密码无效" onblur="_valid.repassword('repassword', this.value, false)" oninput="_valid.repassword('repassword', this.value, false)">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="repassword_txt"></span>
                </div> -->
                <div class="form-group">
                <label class="col-sm-3 control-label">降为普通会员</label>
                <div class="col-sm-4">
                  <label class="col-sm-2 gender_label control-label">
                    <input type="radio" name="user" id="user_male" value="1" checked="checked">否
                  </label>
                  <label class="col-sm-2 gender_label control-label">
                    <input type="radio" name="user" id="user_female" value="2">是
                  </label>
                </div>
                <span class="col-sm-4 text-danger form_error" id="user_txt"></span>
              </div>
                <div class="form-group">
                  <div class="col-sm-offset-3 col-sm-10">
                    <button type="submit" class="btn btn-success btn-100">确认</button>
                    <button type="reset" class="btn btn-success btn-100">重置</button>
                    <a href="{{ url('admin/user/agent') }}"><button type="button" class="btn btn-success btn-100" id="cancel_addAgent">取消</button></a>
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
@endsection

