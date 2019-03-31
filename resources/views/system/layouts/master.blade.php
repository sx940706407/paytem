<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href=" /favicon.ico" /> 
    <title>HT聚合支付系统V0.1</title>

  @include('system/layouts/css')
    
  @yield('css')
  
  <meta name="csrf-token" content="{{ csrf_token() }}">

</head>
<body class="hold-transition sidebar-mini skin-purple-light">

<div class="wrapper">

  @include('system/layouts/header')

  @include('system/layouts/sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        @yield('content-header')
      </section>
      <!-- Main content -->
      <section class="content">
        <!-- Small boxes (Stat box) -->
        @yield('content')

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
  @include('system/layouts/footer')

</div>
<!-- ./wrapper -->
    @include('system/layouts/js')

    @yield('js')

    {{-- 用于websocket显示实时消息，用于监控定时备份，前后非法操作，提现操作====实时消息通知 --}}
</body>
</html>
