@extends('shop/layouts/master')

@section('css')
	@include('common/datatablesCss')

@endsection

@section('content-header')
      <h1>
        支付通知
        <small>cardCircle</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">cardCircle</li>
      </ol>	
@endsection

@section('content')



<div class="col-md-12">

                            <div class="panel panel-default">
                                <div class="panel-heading ui-draggable-handle">
                                    <h3 class="panel-title">支付通道</h3>                               
                                </div>
                                <div class="panel-body">
						                        <div class="col-md-3">
                            <!-- CONTACT ITEM -->
                            <div class="panel panel-default">
                                <div class="panel-body profile">
                                    <div class="profile-image">
                                        <img src=" {{asset('images/zhifubao.Png')}} " alt="支付宝">
                                    </div>
                                    <div class="profile-data">
                                        <div class="profile-data-name">支付宝</div>
                                        <div class="profile-data-title">通道状态：<button type="button" class="btn btn-primary btn-xs"><span class="btn btn-info btn-xs">已开启</span></button></div>
                                    </div>
                                    <div class="profile-controls">
                                        <a href="#" class="profile-control-left" data-toggle="tooltip" data-placement="right" title="支付宝"><span class="fa fa-info"></span></a>
                                    </div>
                                </div>                                
                                <div class="panel-body">                                    
                                    <div class="contact-info">
									<div class="well">
                                        <p><small>通道信息：</small><br></p><hr>
                                        <p><button type="button" class="btn">接口费率：0.02</button> | <button type="button" class="btn">接口代码：alipay</button> </p>                                        
                                        <p></p><div class="text-danger"><b>注意事项</b>：<i>不可用于涉黄赌毒，菠菜，诱导等擦边违法用途</i></div><p></p>  
									</div>
                                    </div>
                                </div>                                
                            </div>
                            <!-- END CONTACT ITEM -->
                        </div>
                        <div class="col-md-3">
                            <!-- CONTACT ITEM -->
                            <div class="panel panel-default">
                                <div class="panel-body profile">
                                    <div class="profile-image">
                                        <img src="{{asset('images/weixin.Png')}}" alt="微信">
                                    </div>
                                    <div class="profile-data">
                                        <div class="profile-data-name">微信</div>
                                        <div class="profile-data-title">通道状态：<button type="button" class="btn btn-primary btn-xs"><span class="btn btn-info btn-xs">已开启</span></button></div>
                                    </div>
                                    <div class="profile-controls">
                                        <a href="#" class="profile-control-left" data-toggle="tooltip" data-placement="right" title="微信"><span class="fa fa-info"></span></a>
                                    </div>
                                </div>                                
                                <div class="panel-body">                                    
                                    <div class="contact-info">
									<div class="well">
                                        <p><small>通道信息：</small><br></p><hr>
                                        <p><button type="button" class="btn">接口费率：0.02</button> | <button type="button" class="btn">接口代码：weixin</button> </p>                                        
                                        <p></p><div class="text-danger"><b>注意事项</b>：<i>不可用于涉黄赌毒，菠菜，诱导等擦边违法用途</i></div><p></p>  
									</div>
                                    </div>
                                </div>                                
                            </div>
                            <!-- END CONTACT ITEM -->
                        </div>
                        <div class="col-md-3">
                            <!-- CONTACT ITEM -->
                            <div class="panel panel-default">
                                <div class="panel-body profile">
                                    <div class="profile-image">
                                        <img src="{{ asset('images/yinlian.png') }}" alt="银联">
                                    </div>
                                    <div class="profile-data">
                                        <div class="profile-data-name">银联</div>
                                        <div class="profile-data-title">通道状态：<button type="button" class="btn btn-primary btn-xs"><span class="btn btn-info btn-xs">已开启</span></button></div>
                                    </div>
                                    <div class="profile-controls">
                                        <a href="#" class="profile-control-left" data-toggle="tooltip" data-placement="right" title="银联"><span class="fa fa-info"></span></a>
                                    </div>
                                </div>                                
                                <div class="panel-body">                                    
                                    <div class="contact-info">
									<div class="well">
                                        <p><small>通道信息：</small><br></p><hr>
                                        <p><button type="button" class="btn">接口费率：0.02</button> | <button type="button" class="btn">接口代码：yinlian</button> </p>                                        
                                        <p></p><div class="text-danger"><b>注意事项</b>：<i>不可用于涉黄赌毒，菠菜，诱导等擦边违法用途</i></div><p></p>  
									</div>
                                    </div>
                                </div>                                
                            </div>
                            <!-- END CONTACT ITEM -->
                        </div>
		
                        <!--div class="col-md-3">
                            <div class="panel panel-default">
                                <div class="panel-body profile">
                                    <div class="profile-image">
                                        <img src="/static/images/qita.png" alt="其他"/>
                                    </div>
                                    <div class="profile-data">
                                        <div class="profile-data-name">其他通道</div>
                                        <div class="profile-data-title">通道状态：<button type="button" class="btn btn-primary btn-xs"><span class='btn btn-danger btn-xs'>待添加</span></button></div>
                                    </div>
                                    <div class="profile-controls">
                                        <a href="#" class="profile-control-left"><span class="fa fa-info"></span></a>
                                    </div>
                                </div>                                
                                <div class="panel-body">                                    
                                    <div class="contact-info">
									<div class="well">
                                        <p><small>通道说明：</small><br/></p><hr>
                                        <p>接口费率： 无</p>                                       
                                        <p><div class="text-danger"><b>注意事项</b>：<i>无</i></div></p>  
									</div>
                                    </div>
                                </div>                                
                            </div>
                        </div-->
                                
                                </div>

</div>

@endsection


@section('js')


	@include('common/datatabelsJs')


@endsection