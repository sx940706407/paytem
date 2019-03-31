@extends('shop/layouts/master')

@section('css')
  @include('common/datatablesCss')

@endsection

@section('content-header')
      <h1>
        批量带付
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
                                    <h3 class="panel-title">操作</h3>                               
                                </div>
                                <div class="panel-body">
      <blockquote>
      
        <p>
          <b style="font-size:20px;"><span class="glyphicon glyphicon-bookmark"></span> 账户可用余额：
          <b style="color:green">3.370</b> 元 </b>　　
        </p>
        <hr>
                         <div class="form-group">
                        <label class="col-md-3 control-label">批量代付文档上传</label>
                        <div class="col-md-9">                                                                                                                                        
                            <a class="file-input-wrapper btn btn-default  fileinput btn-primary"><span>选择文件</span><input type="file" class="fileinput btn-primary" name="xlsfile" id="xlsfile" title="选择文件" style="left: -195.5px; top: -2px;"></a>
                            <span class="help-block">格式必须为.xls</span>
                        </div>
                    </div>
                        <a name="daifu" value="daifu" id="go" onclick="daifu()" class="btn btn-primary pull-right">申请代付</a>
              <hr>
        <p>
          需知：
        </p> <small><cite>代付总金额需要大于<b style="color:red"> 10.000 </b>元；手续费从总费用中扣除（手续费：<b style="color:red">1 % </b>）</cite></small>
          <small><cite>代付xls文档必须 <b style="color:red">严格按照 <a target="_blank" href="批量代付示例.xls">示例文档</a></b> 填写,否者数据出错不予 <b style="color:red">退还金额</b> 。</cite></small>
      </blockquote>
        
                                </div>
                            </div>

                        </div>                   
                        <div class="col-md-12">

                            <div class="panel panel-default">
                                <div class="panel-heading ui-draggable-handle">
                                    <h3 class="panel-title">代付列表</h3>                               
                                </div>
                                <div class="panel-body">
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer"><div class="dataTables_length" id="DataTables_Table_0_length"><label>每页显示 <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="form-control"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> 条数据</label></div><div id="DataTables_Table_0_filter" class="dataTables_filter"><label>搜索订单:<input type="search" class="form-control " placeholder="" aria-controls="DataTables_Table_0"></label></div><table class="table datatable table-hover table-bordered dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                  <thead>
                    <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="编号: 降序排序" style="width: 50px;">编号</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="代付用户: 降序排序" style="width: 93px;">代付用户</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="提现金额: 降序排序" style="width: 83px;">提现金额</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="手续费: 降序排序" style="width: 67px;">手续费</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="实际金额: 降序排序" style="width: 83px;">实际金额</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="收款姓名: 降序排序" style="width: 83px;">收款姓名</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="收款银行: 降序排序" style="width: 172px;">收款银行</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="收款账号: 降序排序" style="width: 182px;">收款账号</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="申请时间: 降序排序" style="width: 159px;">申请时间</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="状态: 降序排序" style="width: 71px;">状态</th></tr>
                  </thead>
                  <tbody>
          
                    

                    

                    
                  <tr role="row" class="odd">
                      <td class="sorting_1">1</td>
                      <td>cotest[代付]</td>
                      <td>820.150</td>
                      <td>8.202</td>
                      <td>811.949</td>
                      <td>王小白</td>
                      <td>交通银行XX支行XX分行</td>
                      <td>6210355030100376992</td>
                      <td>2018-04-12 11:02:11</td>
                      <td><button type="button" class="btn btn-success btn-xs">已代付</button></td>
                    </tr><tr role="row" class="even">
                      <td class="sorting_1">2</td>
                      <td>cotest[代付]</td>
                      <td>120.880</td>
                      <td>3.000</td>
                      <td>117.880</td>
                      <td>李小黑</td>
                      <td>浦发银行XX支行XX分行</td>
                      <td>6217751010003320000</td>
                      <td>2018-04-12 11:02:11</td>
                      <td><button type="button" class="btn btn-success btn-xs">已代付</button></td>
                    </tr><tr role="row" class="odd">
                      <td class="sorting_1">3</td>
                      <td>cotest[代付]</td>
                      <td>520.870</td>
                      <td>5.209</td>
                      <td>515.661</td>
                      <td>郭小红</td>
                      <td>建设银行XX支行XX分行</td>
                      <td>6217211107001880000</td>
                      <td>2018-04-12 11:02:11</td>
                      <td><button type="button" class="btn btn-success btn-xs">已代付</button></td>
                    </tr></tbody>
                </table><div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">当前显示 1 至 3 条 | 共 3 条数据</div><div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate"><a class="paginate_button previous disabled" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0" id="DataTables_Table_0_previous">上一页</a><span><a class="paginate_button current" aria-controls="DataTables_Table_0" data-dt-idx="1" tabindex="0">1</a></span><a class="paginate_button next disabled" aria-controls="DataTables_Table_0" data-dt-idx="2" tabindex="0" id="DataTables_Table_0_next">下一页</a></div></div>
        
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