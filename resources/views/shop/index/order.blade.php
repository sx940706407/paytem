@extends('shop/layouts/master')

@section('css')
	@include('common/datatablesCss')

@endsection

@section('content-header')
      <h1>
        订单信息
        <small>cardCircle</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">cardCircle</li>
      </ol>	
@endsection

@section('content')

<div class="box">
	<div class="box-header">


    <div class="box-header">

        
    </div>

	</div>

	<div class="box-body table-responsive" id="form_do">
		<div class="row">
			<div class="col-md-12">
				<table class="table tale-bordered table-bordered table-hover table-condensed mdl-data-table" id="users-table">
					<thead>
							<tr>
								<th>订单号</th>
                <th>处理时间</th>
                <th>通道</th>
                <th>金额</th>
                <th>所得金额</th>
								<th>状态</th>
							</tr>
					</thead>
				</table>
			</div>
		</div>		
	</div>

	<div class="box-footer">

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