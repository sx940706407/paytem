@extends('shop/layouts/master')

@section('css')
  @include('common/datatablesCss')

@endsection

@section('content-header')
      <h1>
        账户结算
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
          <b style="font-size:20px;"><span class="glyphicon glyphicon-bookmark"></span> 账户可提现余额：
          <b style="color:green">3.370</b> 元 </b>　　
      <button id="sqjs" type="button" class="btn btn-success btn-small">申请结算</button>         
        </p>
        <hr>
              <p>
          需知：
        </p> <small><cite>金额需要大于<b style="color:red"> 10.000 </b>元才能结算！</cite></small>
        <hr>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>提现银行</th>
                      <th>提现账号</th>
                      <th>姓名</th>
                      <th>操作</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>支付宝</td>
                      <td>62284804025648900222</td>
                      <td>李四</td>
                      <td><button id="gg" type="button" class="btn btn-xs">更改</button></td>
                    </tr>
                  </tbody>
                </table>
      </blockquote>
        
                                </div>
                            </div>

                        </div>                   
                        <div class="col-md-12">

                            <div class="panel panel-default">
                                <div class="panel-heading ui-draggable-handle">
                                    <h3 class="panel-title">结算列表</h3>                               
                                </div>
                                <div class="panel-body">
      <blockquote>
        <p>
          提示：
        </p> <small><cite>在提交结算申请后,财务人员会在3天之内为您结算！</cite></small>
      </blockquote>
                <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper no-footer"><div class="dataTables_length" id="DataTables_Table_0_length"><label>每页显示 <select name="DataTables_Table_0_length" aria-controls="DataTables_Table_0" class="form-control"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> 条数据</label></div><div id="DataTables_Table_0_filter" class="dataTables_filter"><label>搜索订单:<input type="search" class="form-control " placeholder="" aria-controls="DataTables_Table_0"></label></div><table class="table datatable table-hover table-bordered dataTable no-footer" id="DataTables_Table_0" role="grid" aria-describedby="DataTables_Table_0_info">
                  <thead>
                    <tr role="row"><th class="sorting_asc" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-sort="ascending" aria-label="编号: 降序排序" style="width: 53px;">编号</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="申请用户: 降序排序" style="width: 87px;">申请用户</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="提现金额: 降序排序" style="width: 97px;">提现金额</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="手续费: 降序排序" style="width: 78px;">手续费</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="实际金额: 降序排序" style="width: 97px;">实际金额</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="收款姓名: 降序排序" style="width: 87px;">收款姓名</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="收款银行: 降序排序" style="width: 87px;">收款银行</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="收款账号: 降序排序" style="width: 200px;">收款账号</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="申请时间: 降序排序" style="width: 166px;">申请时间</th><th class="sorting" tabindex="0" aria-controls="DataTables_Table_0" rowspan="1" colspan="1" aria-label="状态: 降序排序" style="width: 74px;">状态</th></tr>
                  </thead>
                  <tbody>
          
                    
                  <tr role="row" class="odd">
                      <td class="sorting_1">1</td>
                      <td>cotest</td>
                      <td>876189.000</td>
                      <td>8761.890</td>
                      <td>867427.110</td>
                      <td>李四</td>
                      <td>支付宝</td>
                      <td>62284804025648900222</td>
                      <td>2018-04-14 03:47:09</td>
                      <td><button type="button" class="btn btn-success btn-xs">已结算</button></td>
                    </tr></tbody>
                </table><div class="dataTables_info" id="DataTables_Table_0_info" role="status" aria-live="polite">当前显示 1 至 1 条 | 共 1 条数据</div><div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate"><a class="paginate_button previous disabled" aria-controls="DataTables_Table_0" data-dt-idx="0" tabindex="0" id="DataTables_Table_0_previous">上一页</a><span><a class="paginate_button current" aria-controls="DataTables_Table_0" data-dt-idx="1" tabindex="0">1</a></span><a class="paginate_button next disabled" aria-controls="DataTables_Table_0" data-dt-idx="2" tabindex="0" id="DataTables_Table_0_next">下一页</a></div></div>
        
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