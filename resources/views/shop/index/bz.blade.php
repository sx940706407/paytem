@extends('shop/layouts/master')

@section('css')
  @include('common/datatablesCss')

@endsection

@section('content-header')
      <h1>
        帮助中心
        <small>cardCircle</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">cardCircle</li>
      </ol> 
@endsection

@section('content')

<div class="page-content-wrap">
  <div class="row clearfix">
    <div class="col-md-12 column">
      <div class="row clearfix">
        <div class="col-md-7 column">
          <div class="row clearfix">
            <div class="col-md-12 column">
                            <div class="panel panel-default">
                                <div class="panel-heading ui-draggable-handle">
                                    <h3 class="panel-title">服务端SDK下载</h3>                               
                                </div>
                                <div class="panel-body">
                  <div class="row">
                    <div class="col-sm-4 col-md-3">
                      <div class="thumbnail" style="border:0px">
                        <img width="128px" class="img-thumbnail" src="/user/img/php.png" alt="...">
                        <br>
                        <center><a href="#" class="btn btn-info">下载SDK</a></center>
                      </div>
                    </div>
                    <div class="col-sm-4 col-md-3">
                      <div class="thumbnail" style="border:0px">
                        <img width="128px" class="img-thumbnail" src="/user/img/asp.png" alt="...">
                        <br>
                        <center><a href="#" class="btn btn-info">下载SDK</a></center>
                      </div>
                    </div>
                    <div class="col-sm-4 col-md-3">
                      <div class="thumbnail" style="border:0px">
                        <img width="128px" class="img-thumbnail" src="/user/img/aspx.png" alt="...">
                        <br>
                        <center><a href="#" class="btn btn-info">下载SDK</a></center>
                      </div>
                    </div>
                    <div class="col-sm-4 col-md-3">
                      <div class="thumbnail" style="border:0px">
                        <img width="128px" class="img-thumbnail" src="/user/img/jsp.png" alt="...">
                        <br>
                        <center><a href="#" class="btn btn-info">下载SDK</a></center>
                      </div>
                    </div>
                  </div>
                </div>
                            </div>
            </div>
          </div>
          <div class="row clearfix">
            <div class="col-md-6 column">
                            <div class="panel panel-default">
                                <div class="panel-heading ui-draggable-handle">
                                    <h3 class="panel-title">其他SDK下载</h3>                               
                                </div>
                                <div class="panel-body">
                  <div class="row">
                    <div class="col-sm-4 col-md-6">
                      <div class="thumbnail" style="border:0px">
                        <img width="128px" class="img-thumbnail" src="/user/img/anzhuo.png" alt="...">
                        <br>
                        <center><a href="#" class="btn btn-info">下载SDK</a></center>
                      </div>
                    </div>
                    <div class="col-sm-4 col-md-6">
                      <div class="thumbnail" style="border:0px">
                        <img width="128px" class="img-thumbnail" src="/user/img/IOS.png" alt="...">
                        <br>
                        <center><a href="#" class="btn btn-info">下载SDK</a></center>
                      </div>
                    </div>
                  </div>
                </div>
                            </div>
            </div>
            <div class="col-md-6 column">
                            <div class="panel panel-default">
                                <div class="panel-heading ui-draggable-handle">
                                    <h3 class="panel-title">联系客服</h3>                               
                                </div>
                                <div class="panel-body">
                  <div class="row">
                    <div class="col-sm-6 col-md-6">
                      <div class="thumbnail">
                        <img width="128px" src="/user/img/kefu.png" alt="...">
                        <center>
                          <div class="caption">
                          <h3>在线客服</h3>
                          </div>
                        </center>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <a href="#" class="btn btn-default" role="button">ＱＱ:</a><a href="tencent://message/?uin=15130727&amp;Site=http://v2.paytem.cn&amp;Menu=yes">15130727</a>
                      <br>
                      <hr>
                      <a href="#" class="btn btn-default" role="button">微信:</a>weixinhao                      <br>
                      <hr>
                      <a href="#" class="btn btn-default" role="button">电话:</a>(020)-12345678                     <br>
                      <hr>
                    </div>
                  </div>
                </div>
                            </div>
            </div>
          </div>
        </div>
        <div class="col-md-5 column">
          <div class="row clearfix">
            <div class="col-md-12 column">
                            <div class="panel panel-default">
                                <div class="panel-heading ui-draggable-handle">
                                    <h3 class="panel-title">问题反馈</h3>                               
                                </div>
                                <div class="panel-body">
                  <div class="alert alert-success" role="alert">如果你在使用本平台服务过程中遇到问题，请反馈给我们！</div>
                  <form class="col-md-8">
                    <div class="form-group">
                      <label>提交用户：</label>
                      <input type="text" class="form-control" id="yonghu" value="cotest" disabled="">
                      <span class="help-block">--我们将第一时间回复您</span>
                    </div>
                    <div class="form-group">
                      <label>标题：</label>
                      <input type="text" class="form-control" id="biaoti" placeholder="请输入12字内标题">
                      <span class="help-block">--简单标题</span>
                    </div>
                    <div class="form-group">
                      <label>问题详情：</label>
                      <textarea class="form-control" id="neirong" rows="6" placeholder="请输入100字内问题详情"></textarea>
                      <span class="help-block">--请尽量精简明了说明问题</span>
                    </div>
                    <div class="input-group">
                      <a style="background-color:white;border:0px;" class="input-group-addon" href="javascript:void(0)" onclick="document.getElementById('verifyimg').src='/Config/Verify.php?r='+Math.random()"><img id="verifyimg" alt="点击切换" src="/Config/Verify.php?r=9206"></a>
                      <input type="text" id="fkyzm" class="form-control" placeholder="验证码" aria-describedby="basic-addon1">
                    </div>
                    <hr>
                    <button onclick="tijiao()" type="button" class="btn btn-default">提交</button>（系统最多同时处理单个用户2条反馈！）
                  </form> 
                               </div>
                            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>
@endsection


@section('js')


  @include('common/datatabelsJs')
  


  <script>
      $(function(){
        $('#users-table').DataTable({
          order : [[0,'desc']],
          procession: true,
          serverSide: true,
          ajax:{
            url : '{!! route('order.data') !!}',
            data:function(d){
                d.time = $("#reservation1").val();
                d.invite = $("select[name=invite]").val();
                d.agent_id = $("#agent_id").val();

            }
          },
          columns:[
            {data: 'order_id',name:'order_id'},
            {data: 'order_time',name:'order_time'},
            {data: 'order_channel',name:'order_channel'},
            {data: 'order_money',name:'order_money'},
            {data: 'order_me',name:'order_me'},
            {data: 'order_status',name:'order_status'},
          ]
        });
      });
   $('#search-form').on('submit',function(e){
        oTable.draw();
        //AJAX 显示对应的搜索的格式化信息在右边
        e.preventDefault();
   });


</script>



@endsection