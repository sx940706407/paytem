
  <header class="main-header">


<style type="text/css">
  @media all and (max-width: 1200px){
      #logo{
        display: none;
      }
      #sidebar-color{
        background-color: #31b0d5;
      }
  }
</style>


    <!-- Logo -->
    <a href="javascript:;" class="logo" id="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>A</b>L</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><b>商户管理中心</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">

@php
  $managerShow = session('adminAuth');
@endphp

      @if($managerShow == 3 || $managerShow == 10 || $managerShow == 11)
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">1</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">提现失败通知,请留意</li>

              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>

                </ul>
              </li>



              <li class="footer"><a href="#">View all</a></li>

              
            </ul>
          </li>

          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">5</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">提现OK</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">

                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Design some buttons
                        <small class="pull-right">20%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar"
                             aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>



                </ul>
              </li>
              <li class="footer">

                <a href="#">View all tasks</a>
              </li>

            </ul>
          </li>
          <li>
            {{-- <a href="{{url('managerTq78/customCss')}}">个性化配置</a> --}}
          </li>
@endif

          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>

        </ul>
      </div>
    </nav>
</header>