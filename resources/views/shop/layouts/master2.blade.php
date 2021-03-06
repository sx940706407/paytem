<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href=" /favicon.ico" /> 
    <title>商户中心</title>

  @include('shop/layouts/css')

  @yield('css')
  
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
</head>
<body class="hold-transition sidebar-mini skin-purple-light sidebar-collapse ">

<div class="wrapper">

  @include('shop/layouts/header')

  @include('shop/layouts/sidebar')

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
  @include('shop/layouts/footer')

</div>
<!-- ./wrapper -->
    @include('shop/layouts/js')

    @yield('js')
</body>
</html>
