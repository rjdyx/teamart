@extends('fx.admin.layouts.app')

@section('title')
团购活动
@endsection
@section('t1')
促销管理
@endsection
@section('css')
@endsection
@section('script')
@parent
    <script src="{{url('admin/js/upload.js')}}"></script>
<script>
      $(function () {
        datepicker({
            enableTime: true,
            disable: false,
            dateFormat: 'Y-m-d H:i:S',
            mode: 'range',
            onChange: function(selectedDates, dateStr, instance) {
                if (dateStr.indexOf('至') > -1) {
                    console.log(dateStr.split('至'))
                    $('#date_start').val(dateStr.split('至')[0])
                    $('#date_end').val(dateStr.split('至')[1])
                    $('#date_txt').text('')
                }
            }
        })
        var form = document.forms['activity_form']
        $(form).on('submit', function () {
          return submitForm()
        })
        $('#name').on('blur input', function () {
          _valid.title('name', '团购活动名称', $(this).val())
        })
        $('#price').on('blur input', function () {
          _valid.number('price', '团购价格', $(this).val())
        })
        //  $('#date_start').on('blur input', function () {
        //   _valid.birth_date('date_start', '活动开始时间', $(this).val(), true)
        // })
        //   $('#date_end').on('blur input', function () {
        //   _valid.birth_date('date_end', '活动结束时间', $(this).val(), true)
        // })
          $('#desc').on('blur input', function () {
          _valid.desc('desc', '商品组描述', $(this).val())
        })
        function submitForm() {
			var name = form['name']
			var date_start = form['date_start']
			var date_end = form['date_end']
			var price = form['price']
			if (!_valid.title('name', '团购活动名称', name.value)) {
				return false
			}
			if (!date_start.value || !date_end.value) {
				$('#date_txt').text('请选择活动时间')
				return false
			}
			if (!_valid.number('price', '现价', price.value)) {
				return false
			}
			return true
		}
      })
    </script>
@endsection

@section('content')
<!-- Main content of addGgent-->
<section class="content">
	<div class="row">
		<div class="col-xs-12">
			<div class="box box-success">
				<div class="box-header with-border">
					<h3 class="box-title">新增团购</h3>
				</div>
				<!-- /.box-header -->
				<!-- form start -->
				<form class="form-horizontal" action="{{url('admin/activity/group')}}" method="POST" name="activity_form" enctype="multipart/form-data">
				{{ csrf_field() }}
					<div class="box-body">
						<div class="form-group">
							<label for="name" class="col-sm-3 control-label">团购活动名称</label>

							<div class="col-sm-3">
								<input type="text" class="form-control" id="name" placeholder="请输入团购活动名称" name="name">
							</div>
							<span class="col-sm-4 text-danger form_error" id="name_txt"></span>
						</div>
						<div class="form-group">
                            <label class="col-sm-3 control-label" for="date_start">活动时间</label>
                            <div class="col-sm-3">
                                <div class="input-group datetime">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control pull-right" id="datepicker">
                                    <input type="hidden" id="date_start" name="date_start">
                                    <input type="hidden" id="date_end" name="date_end">
                                </div>
                            </div>
                            <span class="col-sm-4 text-danger form_error" id="date_txt"></span>
                        </div>
						<div class="form-group">
							<label for="price" class="col-sm-3 control-label">团购价格</label>

							<div class="col-sm-3">
								<input type="number" class="form-control" id="price" placeholder="请输入团购价数额" name="price">
							</div>
							<span class="col-sm-4 text-danger form_error" id="price_txt"></span>
						</div>
						                <!-- 此处图片上传. -->
		                <div class="form-group">
		                  <label class="col-sm-3 control-label">活动图片</label>
		                  <div class="col-sm-4">
		                    <div class="upload_single">
		                      <label for="img" class="upload pull-left">
		                        <i class="glyphicon glyphicon-plus"></i>
		                      </label>
		                      <label class="btn btn-primary pull-left ml-10 invisible" for="img">修改</label>
		                      <div class="btn btn-danger pull-left ml-10 invisible J_remove">删除</div>
		                      <input type="file" name="img" id="img" class="form-control invisible J_img" accept="image/jpeg,image/jpg,image/png">
		                    </div>
		                  </div>
		                  <span class="col-sm-4 text-danger form_error" id="img_txt"></span>
		                </div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-3">
								<button type="submit" class="btn btn-success btn-100">确认</button>
								<button type="reset" class="btn btn-success btn-100">重置</button>
								<a href="{{url('admin/activity/group')}}"><button type="button" class="btn btn-success btn-100" id="cancel_addUser">取消</button></a>
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
