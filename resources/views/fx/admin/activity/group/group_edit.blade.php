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
<script src="{{url('ueditor/ueditor.config.js')}}"></script>
<script src="{{url('ueditor/ueditor.all.min.js')}}"></script>
<script src="{{url('ueditor/lang/zh-cn/zh-cn.js')}}"></script>
<script>
        //实例化编辑器
        //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
        $(function () {
        	var ue = UE.getEditor('editor');
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
        	// $('#date_start').on('blur input', function () {
        	// 	_valid.birth_date('date_start', '生产日期', $(this).val(), true)
        	// })
        	// $('#date_end').on('blur input', function () {
        	// 	_valid.birth_date('date_end', '生产日期', $(this).val(), true)
        	// })
        	$('#desc').on('blur input', function () {
        		_valid.desc('desc', '商品组描述', $(this).val())
        	})
        	function submitForm() {
        		var name = form['name']
        		var date_start = form['date_start']
        		var date_end = form['date_end']
        		var price = form['price']

        		if (!_valid.title('name', '团购活动名称', name.value, 'article')) {
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
    					<h3 class="box-title">编辑团购</h3>
    				</div>
    				<!-- /.box-header -->
    				<!-- form start -->
    				<form class="form-horizontal" action="{{url('admin/activity/group')}}/{{$data->id}}" method="POST" name="activity_form">
    					{{ csrf_field() }}
    					<input type="hidden" value="PUT" name="_method">
    					<input type="hidden" value="{{$data->id}}" name="id" id="id">
    					<input type="hidden" value="0" name="del" id="del">
    					<div class="box-body">
    						<div class="form-group">
    							<label for="name" class="col-sm-3 control-label">团购活动名称</label>

    							<div class="col-sm-3">
    								<input type="text" class="form-control" id="name" placeholder="请输入团购活动名称" name="name" value="{{$data->name}}">
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
                                        <input type="text" class="form-control pull-right" id="datepicker" value="{{$data->date_start}} 至 {{$data->date_end}}">
                                        <input type="hidden" id="date_start" name="date_start" value="{{$data->date_start}}">
                                        <input type="hidden" id="date_end" name="date_end" value="{{$data->date_end}}">
                                    </div>
                                </div>
                                <span class="col-sm-4 text-danger form_error" id="date_txt"></span>
                            </div>
    						<!-- <div class="form-group">
    							<label class="col-sm-3 control-label" for="date_start">活动开始时间</label>
    							<div class="col-sm-3">
    								<div class="input-group datetime">
    									<div class="input-group-addon">
    										<i class="fa fa-calendar"></i>
    									</div>
    									<input type="datetime" class="form-control pull-right" id="date_start" name="date_start"  value="{{$data->date_start}}">
    								</div>
    							</div>
    						</div>
    						<div class="form-group">
    							<label class="col-sm-3 control-label" for="date_end">活动结束时间</label>
    							<div class="col-sm-3">
    								<div class="input-group datetime">
    									<div class="input-group-addon">
    										<i class="fa fa-calendar"></i>
    									</div>
    									<input type="datetime" class="form-control pull-right" id="date_end" name="date_end"   value="{{$data->date_start}}">
    								</div>
    							</div>
    						</div> -->
    						<div class="form-group">
    							<label for="price" class="col-sm-3 control-label">团购价格</label>

    							<div class="col-sm-3">
    								<input type="number" class="form-control" id="price" placeholder="请输入团购价数额" name="price"  value="{{$data->price}}">
    							</div>
                                <span class="col-sm-4 text-danger form_error" id="price_txt"></span>
    						</div>
    						<div class="form-group">
    							<label class="col-sm-1 control-label" for="editor">活动说明</label>
    							<div class="col-sm-10">
    								<script id="editor" type="text/plain"  name="desc" 
    								style="width:1024px;height:400px;border:1px solid #3DCDB4;">{{$data->desc}}</script>
    							</div>
    						</div>
    						<div class="form-group">
    							<div class="col-sm-offset-2 col-sm-3">
    								<button type="submit" class="btn btn-success btn-100">确认</button>
    								<button type="reset" class="btn btn-success btn-100">重置</button>
    								<a href="{{url('admin/activity/group')}}"><button type="button" class="btn btn-success btn-100" id="cancel_addUser">取消</button></a>
    							</div>
    						</div>
    					</div>
    				</form>
    			</div>
    		</div>
    		<!-- /新增代理商角色 -->
    	</div>
    </section>
    <!-- /.content -->

    @endsection
