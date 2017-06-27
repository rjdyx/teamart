@extends('fx.admin.layouts.app')

@section('title')
后台管理首页
@endsection

@section('css')
	<style>
		.fx-box{background:url('/admin/images/index-bg.png')no-repeat;background-size:100%;margin-top:10px;width:98.6%;margin-left:0.7%;height:800px;padding: 25px;}
		.fx-box-header{width:240px;height:300px;margin:auto;}
		.fx-box-header-box1{width:200px;height:200px;background:white;border-radius:100px;margin:auto;}
		.fx-box-header-box1 img{width:180px;height:180px;border-radius:90px;margin-top:10px;margin-left:10px;border:0;}
		.fx-box-header-box2{width:100%;height:60px;text-align: center;line-height: 60px;font-size:22px;color: white;}
		.fx-box-left{height:300px;width:30%;margin-top:100px;margin-left:10%;float:left;}
		.fx-box-left li{height:40px;width:100%;list-style: none;line-height: 40px;margin-top:20px;}
		.fx-box-left-l{height:16px;width:16px;background: #00A75A;margin-top:12px;float:left;}
		.fx-box-left-r{height:40px;width:80%;line-height: 40px;border-bottom: 2px dotted #00A75A;float:left;margin-left:10px;font-size:25px;color:#767676;}
		.fx-box-right{height:300px;width:50%;margin-top:100px;margin-left:5%;float:left;}

	.chartTips_top span{
      background-color: #fef200;
    }
    .chartTips_middle span{
      background-color: #01aef0;
    }
    .chartTips_top span,.chartTips_middle span{
      display: inline-block;
      width: 20px;
      height: 10px;
      margin-left: 10px;
    }
    .chartTips_bottom{
      position: absolute;
      bottom: 0px;
      left: 0px;
      color: #da712f;
    }
	</style>
@endsection

@section('script')
    @parent
 <script src="{{url('admin/js/Chart.min.js')}}"></script>
 <script type="text/javascript">
	$(function(){
	    //初始化参数设置
	    var areaChartOptions = {
	      //Boolean - 是否显示尺度
	      showScale: true,
	      //Boolean - 是否显示网格线
	      scaleShowGridLines: true,
	      //String - 网格线颜色
	      scaleGridLineColor: "#818287",
	      //Number - 网格线宽度
	      scaleGridLineWidth: 1,
	      //Boolean - 是否显示水平线（除了x轴）
	      scaleShowHorizontalLines: true,
	      //Boolean - 是否显示垂直线（除了y轴）
	      scaleShowVerticalLines: true,
	      //Boolean - 线是否在点之间弯曲
	      bezierCurve: true,
	      //Number - 点间贝塞尔曲线的张力
	      bezierCurveTension: 0.3,
	      //Boolean - 是否为每个点显示一个点
	      pointDot: true,
	      //Number - 每个点的半径以像素为单位
	      pointDotRadius: 4,
	      //Number - 点笔划的像素宽度
	      pointDotStrokeWidth: 1,
	      //Number - 额外添加的半径，以满足在绘制点以外的点击检测。
	      pointHitDetectionRadius: 20,
	      //Boolean - 是否为数据集显示笔划
	      datasetStroke: true,
	      //Number - 数据集笔划的像素宽度
	      datasetStrokeWidth: 2,
	      //Boolean - 是否用颜色填充数据集
	      datasetFill: false,
	      //String - A legend template
	      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].lineColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
	      //Boolean - 当响应时，是否保持起始宽高比，如果设置为false，将占用整个容器。
	      maintainAspectRatio: true,
	      //Boolean - 是否使图表响应窗口大小调整。
	      responsive: true
	    };

	    orderDataReturn();

	    //查询某年每月分销商的订单总数和总金额 
	    function orderDataReturn(year){
	      axios.get('/admin/count/agency/ordercount',{params: {'year':year}})
	      .then(function (res) {
	        orderDataTo(res.data.orders,res.data.prices);
	      })
	    }

	    //加载订单数据方法
	    function orderDataTo(orders,prices){
	      var areaChartData = {
	        labels: ["01", "02", "03", "04", "05", "06", "07","08","09","10","11","12"],
	        datasets: [
	          {
	            label: "订单总数",
	            fillColor: "rgba(210, 214, 222, 1)",
	            strokeColor: "#fef200",
	            pointColor: "#fef200",
	            pointStrokeColor: "#fff",
	            pointHighlightFill: "#fef200",
	            pointHighlightStroke: "#fef200",
	            data: orders
	          },
	          {
	            label: "销售总额",
	            fillColor: "#fff301",
	            strokeColor: "#01aef0",
	            pointColor: "#33bace",
	            pointStrokeColor: "#fff",
	            pointHighlightFill: "#01aef0",
	            pointHighlightStroke: "#01aef0",
	            data: prices
	          }
	        ]
	      };
	      orderStart(areaChartData);
	    }

	    //激活订单图表
	    function orderStart(areaChartData){
	      var lineChartCanvas = $("#lineChartOfYear").get(0).getContext("2d");
	      var lineChart = new Chart(lineChartCanvas);
	      var lineChartOptions = areaChartOptions;
	      lineChart.Line(areaChartData, lineChartOptions);
	    }

	    //年份查询数据
	    $("select[name='yearChange']").change(function(){
	      orderDataReturn($(this).val());
	    });
	});
 </script>
@endsection

@section('content')
<div class="fx-box">
	<div class="fx-box-header">
		<div class="fx-box-header-box1">
			<img src="{{url('')}}/{{Auth::user()->img}}" alt="">
		</div>
		<div class="fx-box-header-box2">{{Auth::user()->name}}</div>
	</div>
	<div class="fx-box-left">
		<li>
			<div class="fx-box-left-l"></div>
			<div class="fx-box-left-r">邮箱: {{Auth::user()->email}}</div>
		</li>
		<li>
			<div class="fx-box-left-l"></div>
			<div class="fx-box-left-r">手机: {{Auth::user()->phone}}</div>
		</li>
		<li>
			<div class="fx-box-left-l"></div>
			<div class="fx-box-left-r">性别: @if(Auth::user()->gender)女@else 男@endif</div>
		</li>
		<li>
			<div class="fx-box-left-l"></div>
			<div class="fx-box-left-r">出生日期: {{Auth::user()->birth_date}}</div>
		</li>	
		<li>
			<div class="fx-box-left-l"></div>
			<div class="fx-box-left-r">真实姓名: {{Auth::user()->realname}}</div>
		</li>		
	</div>
	<div class="fx-box-right">
      <form class="form-horizontal">
        <div class="box-body row" style="margin: 0">
          <!-- .box-body-left -->
          <div class="col-sm-12 box-body-left">
            <div class="chart">
              <div class="chartTips">
                <div class="chartTips_top">销售额<span></span></div>
                <div class="chartTips_middle">订单量<span></span></div>
                <div class="pull-right">订单量/周</div>
              </div>
              <canvas id="lineChartOfYear" style="height:250px"></canvas>
            </div>
          </div>
        </div>
      </form>
	</div>
</div>
@endsection
