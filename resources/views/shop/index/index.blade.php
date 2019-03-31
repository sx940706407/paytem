@extends('shop/layouts/master')


@section('css')

@endsection

@section('content-header')

@endsection

@section('content')



      
      <div class="row">

        <div class="col-md-9">

<div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
              <span class="fa fa-fw fa-user"></span>  商户编号：10001 上次登录时间：2018-07-09 14:17 上次登录IP：157.0.1.50 <a href="">查看详细</a> 
</div>
        <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-aqua">
            <span class="info-box-icon"><i class="fa fa-bookmark-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Bookmarks</span>
              <span class="info-box-number">41,410</span>

              <div class="progress">
                <div class="progress-bar" style="width: 70%"></div>
              </div>
                  <span class="progress-description">
                    70% Increase in 30 Days
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-green">
            <span class="info-box-icon"><i class="fa fa-thumbs-o-up"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">余额</span>
              <span class="info-box-number">41,410 元</span>

              <div class="progress">
                <div class="progress-bar" style="width: 70%"></div>
              </div>
                  <span class="progress-description">
                    (未包括已申请提现金额)
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box bg-red">
            <span class="info-box-icon"><i class="fa fa-comments-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">提现</span>
              <span class="info-box-number">41,410 元</span>

              <div class="progress">
                <div class="progress-bar" style="width: 70%"></div>
              </div>
                  <span class="progress-description">
                   (结算成功的金额)
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
          
        </div>



        <div class="panel panel-primary">
          <!-- Default panel contents -->
          <div class="panel-heading">功能快速通道</div>

          <div class="panel-body">
          <!-- Table -->
          <table class="table">
              <tr>
                <td>
                  <button type="button" class="btn btn-primary btn-block"  data-toggle="tooltip" data-placement="top" title="已开通"><span class="glyphicon glyphicon-cog">
                    </span>商户实名认让</button>
                </td>
              </tr>      <tr>
                <td><button type="button" class="btn btn-primary btn-block" data-toggle="tooltip" data-placement="top" title="已开通"><span class="glyphicon glyphicon-cog">
                    </span>商户API接入</button></td>
              </tr>      <tr>
                <td><button type="button" class="btn btn-primary btn-block" data-toggle="tooltip" data-placement="top" title="已开通"><span class="glyphicon glyphicon-cog">
                    </span>代理商户模式</button></td>
              </tr>      

          </table>    
          </div>

          <div class="panel-footer">
            
          </div>

        </div>
                  



          
        </div>

        <div class="col-md-3">
<div class="panel panel-primary">
  <!-- Default panel contents -->
  <div class="panel-heading">网站公告</div>

  <div class="panel-body">
  <!-- Table -->
  <table class="table">
      <tr>
        <td>公告显示列表12345</td>
      </tr>      <tr>
        <td>公告显示列表12345</td>
      </tr>      <tr>
        <td>公告显示列表12345</td>
      </tr>      <tr>
        <td>公告显示列表12345</td>
      </tr>      <tr>
        <td>公告显示列表12345</td>
      </tr>      <tr>
        <td>公告显示列表12345</td>
      </tr>      <tr>
        <td>公告显示列表12345</td>
      </tr>      <tr>
        <td>公告显示列表12345</td>
      </tr>      <tr>
        <td>公告显示列表12345</td>
      </tr>
  </table>    
  </div>

  <div class="panel-footer">
    
  </div>

</div>
        </div>

        <!-- /.col -->
      </div>



@endsection


@section('js')

<script>
  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
  
</script>
@include('common/highcharts')


   
@endsection