@extends('shop/layouts/master')

@section('css')
	@include('common/datatablesCss')

@endsection

@section('content-header')
      <h1>
        接入信息
        <small>cardCircle</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">cardCircle</li>
      </ol>	
@endsection

@section('content')
<div class="page-content-wrap">                
                
                    <div class="row">
					                        <div class="col-md-12">

                            <div class="panel panel-default">
                                <div class="panel-heading ui-draggable-handle">
                                    <h3 class="panel-title">API相关</h3>                               
                                </div>
                                <div class="panel-body">
								<p>支付网关：</p>
								<blockquote data-toggle="tooltip" data-placement="top" title="" data-original-title="支付网关"><p>http://v2.paytem.cn/pay/api.php</p></blockquote>
								<p>查单网关：</p>
								<blockquote data-toggle="tooltip" data-placement="top" title="" data-original-title="查单网关"><p>http://v2.paytem.cn/pay/order.php</p></blockquote>
								<p>接入ＩＤ：</p>
								<blockquote data-toggle="tooltip" data-placement="top" title="商户API功能唯一标识"><p>10001</p></blockquote>
								<p>密匙ＫＥＹ：</p>
								<blockquote data-toggle="tooltip" data-placement="top" title="用于API接口功能验证"><p id="key">8ndlk0jx14xbkfdy94dlk1oanppm63oz725el2x3</p></blockquote>
								<div class="alert alert-warning alert-dismissible" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
								<strong>注意!</strong> 操作不可逆,请谨慎操作.
								</div>
								<hr>
								<button id="gh" class="btn btn-danger btn-sm">重新生成密匙</button>
                                
                                </div>
                            </div>

                        </div>  
						                    </div>
                
                </div>

@endsection


@section('js')





@endsection