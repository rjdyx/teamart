@extends('fx.admin.layouts.app')
@section('title')新增代理商@endsection
@section('t1')用户管理@endsection
@section('css')
    <link rel="stylesheet" type="text/css" href="{{url('admin/js/datepicker/datepicker3.css')}}">
@endsection
@section('script')
    @parent
    <script src="{{url('admin/js/datepicker/bootstrap-datepicker.js')}}"></script>
    <script src="{{url('admin/js/datepicker/locales/bootstrap-datepicker.zh-CN.js')}}" charset="UTF-8"></script>
    <script src="{{url('admin/js/axios.js')}}"></script>
    <script>
      $(function () {
        $('#datepicker').datepicker({
          language: 'zh-CN',
          format: 'yyyy-mm-dd'
        });
        var form = document.forms['userForm']
        $(form).on('submit', function () {
          return submitForm()
        })
        $('#name').on('blur input', function () {
          vaildName('name', $('#name').val())
        })
        $('#email').on('blur input', function () {
          vaildEmail('email', $('#email').val())
        })
        $('#parter_id').on('change', function () {
          required('parter_id', '代理商角色', $('#parter_id').val())
        })
        $('#gender').on('blur', function () {
          required('gender', '性别', $('#gender').val())
        })
        $('#password').on('blur input', function () {
          vaildPassword('password', $('#password').val())
        })
        $('#repassword').on('blur input', function () {
          vaildRePassword('repassword', $('#repassword').val())
        })
        $('#phone').on('blur input', function () {
          vaildPhone('phone', $('#phone').val())
        })
        $('#realname').on('blur input', function () {
          vaildRealname('realname', $('#realname').val())
        })
        $('#birth_date').on('blur', function () {
          vaildBirth_date('birth_date', $('#birth_date').val())
        })
        function submitForm() {
          console.dir(form)
          var name = form['name']
          var email = form['email']
          var parter_id = form['parter_id']
          var gender = form['gender']
          var password = form['password']
          var repassword = form['repassword']
          var phone = form['phone']
          var realname = form['realname']
          var birth_date = form['birth_date']
          if (!vaildName('name', name.value)) {
            return false
          }
          if (!vaildEmail('email', email.value)) {
            return false
          }
          if (!required('parter_id', '代理商角色', parter_id.value)) {
            return false
          }
          if (!required('gender', '性别', gender.value)) {
            return false
          }
          if (!vaildPassword('password', password.value)) {
            return false
          }
          if (!vaildRePassword('repassword', repassword.value)) {
            return false
          }
          if (!vaildPhone('phone', phone.value)) {
            return false
          }
          if (!vaildRealname('realname', realname.value)) {
            return false
          }
          if (!vaildBirth_date('birth_date', birth_date.value)) {
            return false
          }
          return true
        }
        function required (field, fieldtxt, value) {
          if (value) {
            $('#' + field + '_txt').text('')
            return true
          } else {
            $('#' + field + '_txt').text(fieldtxt + '不能为空')
            return false
          }
        }
        function vaildName (field, value) {
          var vaild = false
          var temp = required(field, '用户名', value)
          if (temp) {
            if (value.length < 4) {
              $('#' + field + '_txt').text('用户名不能少于4个字符')
              vaild = false
            } else {
              // id
              // field
              // value
              // table
              var params = {
                field: 'name',
                table: 'user',
                value: value
              }
              axios.post('/check', params)
                .then(function (res) {
                  if (res.data == 'false') {
                    vaild = true
                  } else {
                    $('#' + field + '_txt').text('该名字已经存在')
                    vaild = false
                  }
                })
                .catch(function (err) {
                  console.log(err)
                })
              $('#' + field + '_txt').text('')
              vaild = true
            }
          }
          return vaild
        }
        function vaildEmail (field, value) {
          var vaild = false
          var reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-])+/; 
          var temp = required(field, '邮箱', value)
          if (temp) {
            if (!reg.test(value)) {
              $('#' + field + '_txt').text('邮箱格式不对')
              vaild = false
            } else {
              $('#' + field + '_txt').text('')
              vaild = true
            }
          }
          return vaild
        }
        function vaildPassword (field, value) {
          var vaild = false
          var temp = required(field, '密码', value)
          if (temp) {
            if (value.length < 6) {
              $('#' + field + '_txt').text('密码至少要6位')
              vaild = false
            } else {
              $('#' + field + '_txt').text('')
              vaild = true
            }
          }
          return vaild
        }
        function vaildRePassword (field, value) {
          var vaild = false
          var temp = required(field, '确认密码', value)
          if (temp) {
            if (value.length < 6) {
              $('#' + field + '_txt').text('确认密码至少要6位')
              vaild = false
            } else {
              if ($('#password').val() !== value) {
                $('#' + field + '_txt').text('两次密码不一致')
                vaild = false
              } else {
                $('#' + field + '_txt').text('')
                vaild = true
              }
            }
          }
          return vaild
        }
        function vaildPhone (field, value) {
          var vaild = true
          if (value) {
            if (!/^1[34578]\d{9}$/.test(value)) {
              $('#' + field + '_txt').text('手机格式不对')
              vaild = false
            } else {
              $('#' + field + '_txt').text('')
              vaild = true
            }
          }
          return vaild
        }
        function vaildRealname (field, value) {
          var vaild = true
          if (value) {
            if (value.length > 6) {
              $('#' + field + '_txt').text('姓名不能大于6位')
              vaild = false
            } else {
              $('#' + field + '_txt').text('')
              vaild = true
            }
          }
          return vaild
        }
        function vaildBirth_date (field, value) {
          var vaild = true
          if (value) {
            if (!/^([0-9]{4})+-([0-1][1-9])+-([0-3][0-9])$/.test(value)) {
              $('#' + field + '_txt').text('出生日期格式为yyyy-mm-dd')
              vaild = false
            } else {
              $('#' + field + '_txt').text('')
              vaild = true
            }
          }
          return vaild
        }
      })
    </script>
@endsection
@section('content')
    <section class="content">
      <div class="row">
        <!-- 新增代理商角色 -->
        <div class="col-xs-12">
          <div class="box box-success">
            <div class="box-header with-border">
              <h3 class="box-title">新增代理商</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{url('admin/user/agent')}}" method="POST" name="userForm">
              {{ csrf_field() }}
              <div class="box-body">
                <div class="form-group">
                  <label for="name" class="col-sm-3 control-label"><i style="color:red;">*</i>用户名</label>
                  <div class="col-sm-4">
                    <input type="text" name="name" class="form-control" id="name" placeholder="请输入用户名">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="name_txt"></span>
                </div>

                <div class="form-group">
                  <label for="email" class="col-sm-3 control-label"><i style="color:red;">*</i>邮箱</label>
                  <div class="col-sm-4">
                    <input type="email" name="email" class="form-control" id="email" placeholder="请输入邮箱">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="email_txt"></span>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label"><i style="color:red;">*</i>代理商角色</label>
                  <div class="col-sm-4">
                    <select class="form-control" name="parter_id">
                      <option value="">请选择代理商角色</option>
                      @foreach($selects as $select)
                      <option value="{{$select->id}}">{{$select->name}} ({{$select->scale}})</option>
                      @endforeach
                    </select>
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="parter_id_txt"></span>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label"><i style="color:red;">*</i>性别</label>
                  <div class="col-sm-4">
                    <label class="col-sm-2 gender_label control-label">
                    <input type="radio" name="gender" id="gender_male" value="0" checked="checked">男
                    </label>
                    <label class="col-sm-2 gender_label control-label">
                      <input type="radio" name="gender" id="gender_female" value="1">女
                    </label>
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="gender_txt"></span>
                </div>
                <div class="form-group">
                  <label for="password" class="col-sm-3 control-label"><i style="color:red;">*</i>登录密码</label>
                  <div class="col-sm-4">
                    <input type="password" name="password" class="form-control" id="password" placeholder="请输入密码">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="password_txt"></span>
                </div>
                <div class="form-group">
                  <label for="repassword" class="col-sm-3 control-label"><i style="color:red;">*</i>确认密码</label>
                  <div class="col-sm-4">
                    <input type="password" class="form-control" id="repassword" placeholder="请再次输入密码">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="repassword_txt"></span>
                </div>
                <div class="form-group">
                  <label for="phone" class="col-sm-3 control-label">手机</label>
                  <div class="col-sm-4">
                    <input type="text" name="phone" class="form-control" id="phone" placeholder="请输入手机号">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="phone_txt"></span>
                </div>
                <div class="form-group">
                  <label for="realname" class="col-sm-3 control-label">姓名</label>
                  <div class="col-sm-4">
                    <input type="text" name="realname" class="form-control" id="realname" placeholder="请输入姓名">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="realname_txt"></span>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label" for="datepicker">出生日期</label>
                  <div class="col-sm-4">
                    <div class="input-group date">
                      <input type="text" name="birth_date" class="form-control pull-right" id="datepicker">
                      <div class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                      </div>
                    </div>
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="birth_date_txt"></span>
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

