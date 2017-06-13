<header class="main-header">
  <!-- Logo -->
  <a href="index2.html" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><b>L</b>GI</span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><img src="{{url('admin/common/dist/img/logo.png')}}" style="height: 45px;width: 100%"></span>
  </a>

  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
      <span class="sr-only">Toggle navigation</span>
    </a>
    <!-- Navbar Right Menu -->
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">

        <li class="dropdown messages-menu">
          <a href="{{url('admin/index')}}" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa  fa-heart-o"></i>
            <span>首页</span>
          </a>
        </li>
        <!-- Messages: style can be found in dropdown.less-->
        <li class="dropdown messages-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa  fa-heart-o"></i>
            <span>帮助</span>
          </a>
        </li>
        <!-- Notifications: style can be found in dropdown.less -->
        <li class="dropdown notifications-menu">
          <a href="{{url('admin/system/shop')}}" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-gear"></i>
            <span>店铺设置</span>
          </a>
        </li>
        <li class="dropdown notifications-menu">
          <a href="{{url('admin/system/personal')}}" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-gear"></i>
            <span>个人设置</span>
          </a>
        </li>
        <!-- Tasks: style can be found in dropdown.less -->
        <li class="dropdown tasks-menu">
          <a href="{{url('/admin/layout')}}" class="dropdown-toggle" data-toggle="dropdown">
            <i class="fa fa-power-off"></i>
            <span>退出系统</span>
          </a>
        </li>
        <!-- Control Sidebar Toggle Button -->
        <li>
          <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
        </li>
      </ul>
    </div>

  </nav>
</header>