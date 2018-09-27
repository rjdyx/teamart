@extends('fx.admin.layouts.app')
@section('title')新增代理商@endsection
@section('t1')用户管理@endsection
@section('css')
@endsection
@section('script')
    @parent
    <script>
      $(function () {
        datepicker();
        $('#datepicker').on('change', function () {
          _valid.birth_date('birth_date', '生产日期', $(this).val(), true)
        })
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
          /*********************2018 09 14 gping add start*************************/
          var scale = form['scale'];
          if(!_valid.ness('scale','提成',scale.value) || !scalechange("#scale")){
            return false;
          }
          /*********************2018 09 14 gping add  end *************************/
          if (!_valid.password('password', password.value)) {
            return false
          }
          if (!_valid.repassword('repassword', repassword.value)) {
            return false
          }
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
      });
      /* gping 20180907 add start*/
      function upserpartercheck() {
          //获取选择的代理商角色
          if($("#parter_id").val() == ''){
              $("#parter_id_txt").text('请选择代理商角色');
              return false;
          }
      }
      //获取上一级代理商列表
      function upperparter(){
          //代理商角色判断
          upserpartercheck();
          //获取选择的代理商角色
          let parterid = $("#parter_id").val();
          //请求，等到上级代理商列表
          upperparterobj = $("#upperparter_id");
          upperparterobj.text("");//清空
          upperparterobj.append('<option value="0">请选择上一级代理商(默认则为一级代理商)</option>');
          axios.post('{{url('/admin/user/parterlist')}}',{parterid:parterid})
              .then(function(res){
                  let index = 0;
                  for(index = 0;index < res.data.length; index++){
                      upperparterobj.append("<option value="+res.data[index].id+">"+res.data[index].name+"</option>");
                  }
              });
      }

      function levelchange(level) {
          if(level == 1){
              $("#upperparter_id").attr('disabled',false);
              $("#maxparternumber").attr('disabled',true);
              // $("#scale").attr('disabled',false);
          }else{
              $("#upperparter_id").attr('disabled',true);
              $("#maxparternumber").attr('disabled',false);
              // $("#scale").attr('disabled',true);
          }
      }
      //提成格式验证函数
      function scalechange(myself) {
          myselfvalue = $(myself).val();
          if(myselfvalue.length == 0){
              $("#scale_txt").text('提成不能为空');
              $("#scale").css('border','1px solid rgb(210,214,222)');
              return false;
          }
          //验证数据
          let regexp = new RegExp(/^\d+(\.){0,1}(\d+)?$/);
          if(regexp.test(myselfvalue) ){
              $("#scale_txt").text('');
              $("#scale").css('border','1px solid rgb(210,214,222)');
              return true;
          }else{
              // console.log('格式有错误！')
              $("#scale_txt").text("提成格式不对！");
              $("#scale").css('border','1px solid red');
              return false;
          }

      }

      /*  gping 20180907 add end*/
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
                    <input type="text" name="name" class="form-control" id="name" placeholder="请输入用户名" onblur="_valid.name('name', '用户名', this.value, 'user')" oninput="_valid.name('name', '用户名', this.value, 'user')">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="name_txt"></span>
                </div>

                <div class="form-group">
                  <label for="email" class="col-sm-3 control-label"><i style="color:red;">*</i>邮箱</label>
                  <div class="col-sm-4">
                    <input type="email" name="email" class="form-control" id="email" placeholder="请输入邮箱" onblur="_valid.email('email', this.value)" oninput="_valid.email('email', this.value)">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="email_txt"></span>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label"><i style="color:red;">*</i>代理商角色</label>
                  <div class="col-sm-4">
                    <select class="form-control" name="parter_id" id="parter_id" onchange="_valid.ness('parter_id', '代理商角色', this.value); upperparter();">
                      <option value="">请选择代理商角色</option>
                      @foreach($selects as $select)
                      <option value="{{$select->id}}">{{$select->name}} ({{$select->scale}})</option>
                      @endforeach
                    </select>
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="parter_id_txt"></span>
                </div>
                <!-- 2018-09-06 gping add start -->
                  <div class="form-group">
                      <label class="col-sm-3 control-label"><i style="color:red;">*</i>代理商级别</label>
                      <div class="col-sm-4">
                          <label class="col-sm-4 parterlevel_label control-label">
                              <input type="radio" name="parterlevel" id="levelone" value="0" onchange="levelchange(0)" checked="checked">一级代理商
                          </label>
                          <label class="col-sm-4 parterlevel_label control-label">
                              <input type="radio" name="parterlevel" id="leveltwo" value="1" onchange="levelchange(1)">二级代理商
                          </label>
                      </div>
                      <span class="col-sm-4 text-danger form_error" id="parterlevel_txt"></span>
                  </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label"><i style="color:red;">*</i>上一级代理商</label>
                  <div class="col-sm-4">
                    <select class="form-control" name="upperparter_id" id="upperparter_id" onfocus="upserpartercheck()" disabled>
                      <option value="0">请选择上一级代理商(默认则为一级代理商)</option>
                    </select>
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="upperparter_id_txt"></span>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label"><i style="color:red;">*</i>最大二级经销商个数</label>
                  <div class="col-sm-4">
                      <input type="number" id="maxparternumber" name="maxparternumber" class="form-control" value="10" min="1" />
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="maxparternumber_txt"></span>
                </div>
                <div class="form-group">
                  <label for="scale" class="col-sm-3 control-label"><i style="color:red;">*</i>提成</label>
                  <div class="col-sm-4">
                    <input type="text" name="scale" class="form-control" id="scale" placeholder="请输入提成数据" onblur="scalechange(this)" oninput="scalechange(this)">
                    {{--oninput="_valid.phone('scale', this.value)" onblur="_valid.phone('phone', this.value)"--}}
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="scale_txt"></span>
                </div>
                <!-- 2018-09-06 gping add end -->
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
                    <input type="password" name="password" class="form-control" id="password" placeholder="请输入密码" onblur="_valid.password('password', this.value)" oninput="_valid.password('password', this.value)">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="password_txt"></span>
                </div>
                <div class="form-group">
                  <label for="repassword" class="col-sm-3 control-label"><i style="color:red;">*</i>确认密码</label>
                  <div class="col-sm-4">
                    <input type="password" class="form-control" id="repassword" placeholder="请再次输入密码" onblur="_valid.repassword('repassword', this.value)" oninput="_valid.repassword('repassword', this.value)">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="repassword_txt"></span>
                </div>
                <div class="form-group">
                  <label for="phone" class="col-sm-3 control-label"><i style="color:red;">*</i>手机</label>
                  <div class="col-sm-4">
                    <input type="text" name="phone" class="form-control" id="phone" placeholder="请输入手机号" oninput="_valid.phone('phone', this.value)" onblur="_valid.phone('phone', this.value)">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="phone_txt"></span>
                </div>
                <div class="form-group">
                  <label for="realname" class="col-sm-3 control-label">姓名</label>
                  <div class="col-sm-4">
                    <input type="text" name="realname" class="form-control" id="realname" placeholder="请输入姓名" oninput="_valid.realname('realname', this.value)" onblur="_valid.realname('realname', this.value)">
                  </div>
                  <span class="col-sm-4 text-danger form_error" id="realname_txt"></span>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label" for="datepicker"><i style="color:red;">*</i>出生日期</label>
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

