<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{url('admin/common/dist/img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>Alexander Pierce</p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu">
      <li class="header">管理员功能</li>
      <li class="treeview">
        <a href="javascript:;">
          <i class="fa fa-dashboard"></i><span>用户管理</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{url('admin/user/agentrole')}}"><i class="fa fa-circle-o"></i> 代理商角色</a></li>
          <li><a href="{{url('admin/user/list')}}"><i class="fa fa-circle-o"></i>用户列表</a></li>
          <li><a href="{{url('admin/user/agent')}}"><i class="fa fa-circle-o"></i>代理商</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-files-o"></i><span>商品管理</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="{{url('admin/goods/category')}}"><i class="fa fa-circle-o"></i>商品分类</a></li>
          <li><a href="{{url('admin/goods/spec')}}"><i class="fa fa-circle-o"></i>商品规格</a></li>
          <li><a href="{{url('admin/goods/brand')}}"><i class="fa fa-circle-o"></i>商品品牌</a></li>
          <li><a href="{{url('admin/goods/list')}}"><i class="fa fa-circle-o"></i>商品列表</a></li>
          <li><a href="{{url('admin/goods/comment')}}"><i class="fa fa-circle-o"></i>用户评论</a></li>
        </ul>
      </li>
      <li>
        <a href="pages/widgets.html">
          <i class="fa fa-th"></i> <span>订单管理</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="pages/layout/top-nav.html"><i class="fa fa-circle-o"></i>订单列表</a></li>
          <li><a href="pages/layout/boxed.html"><i class="fa fa-circle-o"></i>发货订单列表</a></li>
          <li><a href="pages/layout/fixed.html"><i class="fa fa-circle-o"></i>退货订单列表</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-bar-chart-o"></i><span>报表统计</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="pages/charts/chartjs.html"><i class="fa fa-circle-o"></i>客户分析</a></li>
          <li><a href="pages/charts/morris.html"><i class="fa fa-circle-o"></i>商品订单</a></li>
          <li><a href="pages/charts/flot.html"><i class="fa fa-circle-o"></i>代理商销售</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-laptop"></i><span>文章管理</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="pages/UI/general.html"><i class="fa fa-circle-o"></i>文章分类</a></li>
          <li><a href="pages/UI/icons.html"><i class="fa fa-circle-o"></i>文章列表</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-edit"></i> <span>促销管理</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="pages/forms/general.html"><i class="fa fa-circle-o"></i>团购活动</a></li>
          <li><a href="pages/forms/advanced.html"><i class="fa fa-circle-o"></i>积分商品</a></li>
          <li><a href="pages/forms/editors.html"><i class="fa fa-circle-o"></i>优惠券</a></li>
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa fa-table"></i> <span>系统管理</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="pages/tables/simple.html"><i class="fa fa-circle-o"></i>店铺设置</a></li>
          <li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i>支付设置</a></li>
          <li><a href="pages/tables/simple.html"><i class="fa fa-circle-o"></i>配送设置</a></li>
          <li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i>广告管理</a></li>
          <li><a href="pages/tables/simple.html"><i class="fa fa-circle-o"></i>站点设置</a></li>
          <li><a href="pages/tables/data.html"><i class="fa fa-circle-o"></i>个人中心</a></li>
        </ul>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>