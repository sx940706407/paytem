@extends('shop/layouts/master')


@section('css')

@endsection

@section('content-header')
      <h1>
        账户信息
        <small>cardCircle</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">cardCircle</li>
      </ol> 
@endsection

@section('content')


<div class="row">
                        <div class="col-md-8">

                                <div class="panel-body">
                

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist" style="margin-top:-15px;background-color:#ffffff;">
    <li role="presentation" class=""><a href="#jbxx" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="false">基本信息</a></li>
    <li role="presentation" class=""><a href="#dlxgxx" aria-controls="dlxgxx" role="tab" data-toggle="tab" aria-expanded="false">登录信息</a></li>
    <li role="presentation" class=""><a href="#xgzl" aria-controls="xgzl" role="tab" data-toggle="tab" aria-expanded="false">修改资料</a></li>
    <li role="presentation" class="active"><a href="#xgmm" aria-controls="xgmm" role="tab" data-toggle="tab" aria-expanded="true">修改密码</a></li>
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">
    <div role="tabpanel" class="tab-pane" id="jbxx">
    <div class="panel panel-default">
      <div class="panel-body">
      <hr>
        <table class="table table-bordered">
          <tbody>
            <tr>
            <td class="col-md-2" style="background-color:#eee;"><b class="title">用户名：</b></td>
            <td class="col-md-10">cotest</td>
            </tr>
            <tr>
            <td class="col-md-2" style="background-color:#eee;"><b class="title">API功能：</b></td>
            <td class="col-md-10"><button type="button" class="btn btn-success btn-xs">已开通</button></td>
            </tr>
            <tr>
            </tr><tr style="">
            <td class="col-md-2" style="background-color:#eee;"><b class="title">费率：</b></td>
            <td class="col-md-10">0.06</td>
            </tr>
            <tr>
            <td class="col-md-2" style="background-color:#eee;"><b class="title">姓名：</b></td>
            <td class="col-md-10">李四</td>
            </tr>
            <tr>
            <td class="col-md-2" style="background-color:#eee;"><b class="title">性别：</b></td>
            <td class="col-md-10">男</td>
            </tr>
            <tr>
            <td class="col-md-2" style="background-color:#eee;"><b class="title">地址：</b></td>
            <td class="col-md-10">3</td>
            </tr>
            <tr>
            <td class="col-md-2" style="background-color:#eee;"><b class="title">手机：</b></td>
            <td class="col-md-10">18275201265</td>
            </tr>
            <tr>
            <td class="col-md-2" style="background-color:#eee;"><b class="title">联系QQ/微信：</b></td>
            <td class="col-md-10">15130727</td>
            </tr>
            <tr>
            <td class="col-md-2" style="background-color:#eee;"><b class="title">邮箱：</b></td>
            <td class="col-md-10">15130727@qq.com</td>
            </tr>
            <tr>
            <td class="col-md-2" style="background-color:#eee;"><b class="title">注册时间：</b></td>
            <td class="col-md-10">2018-01-07 16:40:27</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
    <div role="tabpanel" class="tab-pane" id="dlxgxx">
    <div class="panel panel-default">
      <div class="panel-body">
        <hr>
        <blockquote>上次登陆ＩＰ: <span style="color:green">157.0.1.50</span> - 上次登陆时间: <span style="color:green">2018-07-09 14:17</span></blockquote><blockquote>本次登陆ＩＰ: <span style="color:red">116.24.67.17</span> - 本次登陆时间: <span style="color:red">2018-07-09 14:31</span></blockquote>
<div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
  <strong>注意!</strong> 请务必关注登陆信息,以防账号被盗损失.
</div>
      </div>
    </div>
  </div>
    <div role="tabpanel" class="tab-pane" id="xgzl">
    <div class="panel panel-default">
      <div class="panel-body">
      <hr>
                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">联系QQ/微信</label>
                                                <div class="col-md-9 col-xs-12">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-flickr"></span></span>
                                                        <input id="xgqq" type="text" class="form-control" value="15130727">
                                                    </div>            
                                                    <span class="help-block">（修改）</span>
                                                </div>
                                            </div>
                      
                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">手机号</label>
                                                <div class="col-md-9 col-xs-12">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-earphone"></span></span>
                                                        <input id="xgsj" type="text" class="form-control" value="18275201265">
                                                    </div>            
                                                    <span class="help-block">（修改）</span>
                                                </div>
                                            </div>
                      
                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">邮箱</label>
                                                <div class="col-md-9 col-xs-12">
                                                    <div class="input-group">
                                                        <span class="input-group-addon">@</span>
                                                        <input id="xgyx" type="mail" class="form-control" value="15130727@qq.com">
                                                    </div>            
                                                    <span class="help-block">（重要）</span>
                                                </div>
                                            </div>
                      
                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">联系地址</label>
                                                <div class="col-md-9 col-xs-12">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-map-marker"></span></span>
                                                        <input id="xgdz" type="text" class="form-control" value="3">
                                                    </div>            
                                                    <span class="help-block">（修改）</span>
                                                </div>
                                            </div>
                                            
                      <div class="panel-footer">
                                          <button id="xgxzl" value="xg" onclick="xgzl()" class="btn btn-primary pull-right">确认修改</button>
                                      </div>
      </div>
    </div>
  </div>
  
  
    <div role="tabpanel" class="tab-pane active" id="xgmm">
    <div class="panel panel-default">
      <div class="panel-body">
      <hr>
                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">原密码</label>
                                                <div class="col-md-9 col-xs-12">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
                                                        <input id="ymm" type="password" class="form-control">
                                                    </div>            
                                                    <span class="help-block">（不修改请留空）</span>
                                                </div>
                                            </div>
                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">新密码</label>
                                                <div class="col-md-9 col-xs-12">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
                                                        <input id="xmm" type="password" class="form-control">
                                                    </div>            
                                                    <span class="help-block">（请注意密码的复杂程度）</span>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">确认新密码</label>
                                                <div class="col-md-9 col-xs-12">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="fa fa-unlock-alt"></span></span>
                                                        <input id="qrxmm" type="password" class="form-control">
                                                    </div>            
                                                    <span class="help-block">（再次输入）</span>
                                                </div>
                                            </div>
                                            <div class="form-group">                                        
                                                <label class="col-md-3 control-label">验证码</label>
                                                <div class="col-md-7 col-xs-12">
                                                    <div class="input-group">
                                                        <span class="input-group-addon"><span class="glyphicon glyphicon-info-sign"></span></span>
                                                        <input id="xgmmyzm" type="text" class="form-control">
                                                    </div>            
                                                    <span class="help-block">请输入验证码</span>
                                                </div>
                                                <div class="col-md-2 col-xs-12">
                          <a href="javascript:void(0)" onclick="document.getElementById('verifyimg').src='/Config/Verify.php?r='+Math.random()"><img id="verifyimg" alt="点击切换" src="/Config/Verify.php?r=1910"></a>
                                                </div>
                                            </div>
                      <div class="panel-footer">
                                          <button id="xgxmm" value="xg" onclick="xgxmm()" class="btn btn-primary pull-right">确认修改</button>
                                      </div>
      </div>
    </div>
  </div>
  </div>

                                </div>

                        </div>
            
                        <div class="col-md-4">
                            <div class="panel panel-default">
                                <div class="panel-heading ui-draggable-handle">
                                    <h3 class="panel-title">实名认证状态</h3>                               
                                </div>
                                <div class="panel-body">
                <div class="col-md-6"><img src="{{ asset('images/yishiming.png') }}" class="center-block"></div><div class="col-md-6"><h1><button class="btn btn-success">已实名认证,所有功能开放！</button></h1></div>                 
                                </div>
                            </div>
                        </div>                   
                        <div class="col-md-4">
                            <div class="panel panel-default">
                                <div class="panel-body">
                  <blockquote><p>注意：为保证商户功能正常使用,请及时进行实名认证.</p><p>如不认证核心功能将关闭.</p></blockquote>
                                </div>
                            </div>
                        </div>                   
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