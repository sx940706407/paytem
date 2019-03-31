  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->

      <!-- search form -->
{{--       <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
          <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> --}}
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">功能导航</li>
          
<li><a href="{{url('shop/index')}}"><i class="glyphicon glyphicon-home"></i> <span>商户主页 </span></a></li>
<li><a href="{{url('shop/user')}}"><i class="fa fa-user"></i> <span>帐号信息</span></a></li>
<li><a href="{{url('shop/order')}}"><i class="fa fa-credit-card"></i> <span>订单记录</span></a></li>

<li><a href="{{url('shop/payChannel')}}"><i class="fa fa-fire"></i> <span>支付通道</span></a></li>
<li><a href="{{url('shop/api')}}"><i class="glyphicon glyphicon-indent-left"></i> <span>接入信息</span></a></li>
<li><a href="{{url('shop/js')}}"><i class="fa fa-cny"></i> <span>账号结算</span></a></li>
<li><a href="{{url('shop/df')}}"><i class="fa fa-money"></i> <span>批量代付</span></a></li>
<li><a href="{{url('shop/bz')}}"><i class="fa fa-group"></i> <span>帮助中心</span></a></li>
      </ul>

    </section>
    
    <!-- /.sidebar -->
  </aside>
