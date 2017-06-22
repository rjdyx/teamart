<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="{{Auth::user()->img==null?'/admin/images/user2-160x160.jpg':url(Auth::user()->img)}}" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p>{{empty(Auth::user())?'未登录':Auth::user()->name}}</p>
        <a href="#"><i class="fa fa-circle text-success"></i>管理员</a>
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
          <li><a href="/admin/user/agentrole"><i class="fa fa-circle-o"></i> 代理商角色</a></li>
          <li><a href="/admin/user/agent"><i class="fa fa-circle-o"></i>代理商</a></li>
          <li><a href="/admin/user/list"><i class="fa fa-circle-o"></i>用户列表</a></li>
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
          <li><a href="{{url('admin/goods/group')}}"><i class="fa fa-circle-o"></i>商品组</a></li>
          <li><a href="{{url('admin/goods/list')}}"><i class="fa fa-circle-o"></i>商品列表</a></li>
          <li><a href="{{url('admin/goods/comment')}}"><i class="fa fa-circle-o"></i>商品评论</a></li>

<!--           <li><a href="/admin/goods/category"><i class="fa fa-circle-o"></i>商品分类</a></li>
          <li><a href="/admin/goods/spec"><i class="fa fa-circle-o"></i>商品规格</a></li>
          <li><a href="/admin/goods/brand"><i class="fa fa-circle-o"></i>商品品牌</a></li>
          <li><a href="/admin/goods/group"><i class="fa fa-circle-o"></i>商品组</a></li>
          <li><a href="/admin/goods/list"><i class="fa fa-circle-o"></i>商品列表</a></li>
          <li><a href="/admin/goods/comment"><i class="fa fa-circle-o"></i>用户评论</a></li> -->

        </ul>
      </li>
      <li>
        <a href="#">
          <i class="fa fa-th"></i> <span>订单管理</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="/admin/order/list"><i class="fa fa-circle-o"></i>订单列表</a></li>
          <li><a href="/admin/order/fade"><i class="fa fa-circle-o"></i>退货订单</a></li>
          <li><a href="/admin/order/close"><i class="fa fa-circle-o"></i>已完成订单</a></li>
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
          <li><a href="/admin/count/client"><i class="fa fa-circle-o"></i>客户分析</a></li>
          <li><a href="/admin/count/product"><i class="fa fa-circle-o"></i>商品订单</a></li>
          <li><a href="/admin/count/agency"><i class="fa fa-circle-o"></i>代理商销售</a></li>
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
          <li><a href="/admin/article/category"><i class="fa fa-circle-o"></i>文章分类</a></li>
          <li><a href="/admin/article/list"><i class="fa fa-circle-o"></i>文章列表</a></li>
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
          <li><a href="/admin/activity/group"><i class="fa fa-circle-o"></i>团购活动</a></li>
          <li><a href="/admin/activity/mark"><i class="fa fa-circle-o"></i>积分商品</a></li>
          <li><a href="/admin/activity/roll"><i class="fa fa-circle-o"></i>优惠券</a></li>
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
          <li><a href="/admin/system/pay"><i class="fa fa-circle-o"></i>支付设置</a></li>
          <li><a href="/admin/system/send"><i class="fa fa-circle-o"></i>配送设置</a></li>
          <li><a href="/admin/system/ad"><i class="fa fa-circle-o"></i>广告管理</a></li>
          <li><a href="/admin/system/site"><i class="fa fa-circle-o"></i>站点设置</a></li>
          <li><a href="/admin/system/feedback"><i class="fa fa-circle-o"></i>意见反馈</a></li>
          <li><a href="/admin/system/log"><i class="fa fa-circle-o"></i>操作日志</a></li>
        </ul>
      </li>
    </ul>
  </section>

</aside>