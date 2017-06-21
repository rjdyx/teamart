@extends('fx.admin.layouts.app')

@section('title')
代理商统计
@endsection

@section('css')
    <style type="text/css">
    .content-header>h1{
      font-size: 18px;
      margin: 0;
    }
    .box-header>.box-tools{
      top: 10px;
    }
    .main-sidebar .user-panel{
      border-bottom: 1px solid #c0c0c0;
      line-height: 40px;
      padding-left: 15px;
    }
    td,th{
      text-align: center;
    }
    .content-header{
      box-sizing: border-box;
      border-bottom: 1px solid #c5c5c5;
      padding-bottom: 10px;
      padding-left: 0px;
      padding-right: 0px;
      margin: 0 15px 0 15px;
    }
    
    .box-footer-left{
      /*padding: 8px;*/
      float: left;
      display: inline-block;
      
      text-align: center;
    }
    .btn-100{
      width: 100px;
      margin-right: 20px;
    }
    .gender_label{
      text-align: left !important;
    }
    #agentRole{
      display: block;
    }
    #addAgent{
      display: block;
    }
    .text-left button,.box-footer button{
      margin: 0px 5px;
    }
    .chart{
      margin: 100px 10px;
      overflow: visible;
    }
    .chartTips{
      position: absolute;
      top: -75px;
      left: 0px;
      width: 100%;
      height: 75px;
    }
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
    
    var areaChartData = {
      labels: ["2017-01", "2017-02", "2017-03", "2017-04", "2017-05", "2017-06", "2017-07","2017-08","2017-09","2017-10","2017-11"],
      datasets: [
        {
          label: "订单总数",
          fillColor: "rgba(210, 214, 222, 1)",
          strokeColor: "#fef200",
          pointColor: "#fef200",
          pointStrokeColor: "#fff",
          pointHighlightFill: "#fef200",
          pointHighlightStroke: "#fef200",
          data: [500,600,700,200,300,455,622,788,986,522,122]
        },
        {
          label: "销售总额",
          fillColor: "#fff301",
          strokeColor: "#01aef0",
          pointColor: "#33bace",
          pointStrokeColor: "#fff",
          pointHighlightFill: "#01aef0",
          pointHighlightStroke: "#01aef0",
          data: [28, 48, 40, 19, 86, 27, 90,19, 86, 27, 90]
        }
      ]
    };

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

    //-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $("#lineChartOfYear").get(0).getContext("2d");
    var lineChart = new Chart(lineChartCanvas);
    var lineChartOptions = areaChartOptions;
    lineChart.Line(areaChartData, lineChartOptions);
  

    //-------------
    //- BAR CHART -
    //-------------
    var orderBarData = {
      labels: ["2017-01", "2017-02", "2017-03", "2017-04", "2017-05", "2017-06", "2017-07","2017-08","2017-09","2017-10","2017-11"],
      datasets: [
        {
          label: "前一月订单量",
          fillColor: "#fef200",
          strokeColor: "#fef200",
          pointColor: "#fef200",
          pointStrokeColor: "#fff",
          pointHighlightFill: "#fef200",
          pointHighlightStroke: "#fef200",
          data: [500,600,700,200,300,455,622,788,986,522,122]
        },
        {
          label: "后一月订单量",
          fillColor: "#01aef0",
          strokeColor: "#01aef0",
          pointColor: "#01aef0",
          pointStrokeColor: "#fff",
          pointHighlightFill: "#01aef0",
          pointHighlightStroke: "#01aef0",
          data: [28, 48, 40, 19, 86, 27, 90,19, 86, 27, 90]
        }
      ]
    };
    var barChartOptions = {
      //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
      scaleBeginAtZero: true,
      //Boolean - Whether grid lines are shown across the chart
      scaleShowGridLines: true,
      //String - Colour of the grid lines
      scaleGridLineColor: "#818287",
      //Number - Width of the grid lines
      scaleGridLineWidth: 1,
      //Boolean - Whether to show horizontal lines (except X axis)
      scaleShowHorizontalLines: true,
      //Boolean - Whether to show vertical lines (except Y axis)
      scaleShowVerticalLines: false,
      //Boolean - If there is a stroke on each bar
      barShowStroke: true,
      //Number - Pixel width of the bar stroke
      barStrokeWidth: 2,
      //Number - Spacing between each of the X value sets
      barValueSpacing: 5,
      //Number - Spacing between data sets within X values
      barDatasetSpacing: 1,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>",
      //Boolean - whether to make the chart responsive
      responsive: true,
      maintainAspectRatio: true
    };

    var barChartCanvas = $("#orderBarChart").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas);
    var barChartData = orderBarData;
    barChartOptions.datasetFill = false;
    barChart.Bar(barChartData, barChartOptions);

    var barChartCanvas = $("#salesBarChart").get(0).getContext("2d");
    var barChart = new Chart(barChartCanvas);
    var barChartData = orderBarData;
    barChartOptions.datasetFill = false;
    barChart.Bar(barChartData, barChartOptions);

    });
</script>
@endsection

@section('content')
   @include("fx.admin.layouts.header")

   @include("fx.admin.layouts.left")
   
   <div class="content-wrapper">
    
    <!-- addagent -->
    <div id="addAgent">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          <a href="#" style="color: #000"><i class="fa fa-home fa_skin" style="margin-right:4px"></i>报表统计</a>
          <a href="#"><small class="fa_skin"><i class="fa fa-angle-right" style="margin-right: 4px"></i>代理商销售</small></a>
        </h1>
      </section>
      <!-- Main content of addGgent-->
      <section class="content">
        <div class="row">
          <!-- 新增代理商角色 -->
          <div class="col-xs-12">
            <div class="box box-success">
              <!-- 第一排信息 -->
              <div class="box-header">
                <h3 class="box-title">代理商销售</h3>
                <div class="box-tools" style="top: 5px;">
                  <ul class="pagination pagination-sm no-margin pull-right">
                    <li><a href="#">分析图下载</a></li>
                  </ul>
                </div>
              </div>
              <!-- /.box-header -->
              <form class="form-horizontal">
                <div class="box-body row" style="margin: 0">
                  <!-- .box-body-left -->
                  <div class="col-sm-12 box-body-left">
                    <div class="chart">
                      <div class="chartTips">
                        <div class="chartTips_top">代理商销售单数总数<span></span></div>
                        <div class="chartTips_middle">代理商销售订单总额<span></span></div>
                        <div class="chartTips_bottom">单量</div>
                        <div class="pull-right">客户数量/月份</div>
                      </div>
                      <canvas id="lineChartOfYear" style="height:250px"></canvas>
                    </div>
                  </div>
                  <!-- /.box-body-left -->
                </div>
                <!-- /.box-body -->
              </form>
            </div>
          </div>
          <!-- /新增代理商角色 -->
        </div>
      </section>
      <!-- /.content -->
    </div>
    <!-- /addagent -->
  </div>

@endsection
