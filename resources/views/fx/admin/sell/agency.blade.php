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
      <section class="content-header">
        <h1>
          <a href="#" style="color: #000"><i class="fa fa-home fa_skin" style="margin-right:4px"></i>报表统计</a>
          <a href="#"><small class="fa_skin"><i class="fa fa-angle-right" style="margin-right: 4px"></i>代理商销售</small></a>
        </h1>
      </section>
      <!-- Main content of addGgent-->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box box-success">
              <!-- 第一排信息 -->
              <div class="box-header">
                <h3 class="box-title">代理商销售</h3>
                <div class="box-tools" style="top: 5px;">
                  <ul class="pagination pagination-sm no-margin pull-right">
                    <li>
                      <select name="yearChange" style="height:30px;">
                        <option value="">-选择年份查询-</option>
                        @foreach($years as $year)
                        <option value="{{$year}}" @if($year== date('Y')) selected @endif>{{$year}}</option>
                        @endforeach
                      </select>
                     </li>
                    <!-- <li><a href="#">分析图下载</a></li> -->
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
@endsection
