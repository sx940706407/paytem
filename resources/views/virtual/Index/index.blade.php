@extends('virtual/layout/master')

@section('css')
	{{-- @include('common/datatables_css') --}}
@endsection

@section('content-header')
      <h1>
        商户提现
        <small>提现</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Admin</a></li>
        <li class="active">提现</li>
      </ol>	
@endsection

@section('content')
<div class="box">
	<div class="box-header">
		{{-- <form  class="form-inline pull-left" role="form" method="GET">
			@include('Search/time')
			<button id="search-form"  class="btn btn-primary btn-md">Search</button>
		</form>
		  @include('flash::message') --}}
		  <p class="pull-left text-danger">
		  余额手动刷新(5秒左右):  <a type="button" class="btn btn-info btn-sm" href="{{url('virtual/refreshBalance')}}">刷新</a> <br/>
			  1.须知: 银行卡信息必须填写,配置提现余额大于或等于100 (方可提现)  <br/>
			  2.提现前 (手动刷新余额) 提现分为两种 带客服审核,自动通过 当前为自动通过
		  </p>
	</div>

	<div class="box-body table-responsive" id="form_do">
		<div class="row">
			<div class="col-md-12">
				<table class="table tale-bordered table-bordered table-hover table-condensed"  >
					<thead>
							<tr>
								<th>名称</th>
								<th>余额</th>
								<th>Tn</th>
								<th>币种</th>
								<th>银行卡编辑</th>
								<th>提现</th>
							</tr>
					</thead>
					<tbody>
						@if(isset($shop))

							@foreach($shop as $s)
								<tr>
									<td>{{$s->username}}</td>
									<td>{{$s->balance}}</td>
									<td>{{$s->frozen_amount}}</td>
									<td>{{$s->coin_code}}</td>
									<td><button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal{{$s->id}}">银行卡添加</button></td>
								<td>
									<a href="{{url('virtual/withdraw')}}/{{$s->id}}" class="btn btn-primary btn-sm" target="_blank">提现</a>
								</td>
								
								</tr>

	  
	  <!-- Modal -->
	  <div class="modal fade" id="myModal{{$s->id}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel{{$s->id}}">
		<div class="modal-dialog" role="document">
		  <div class="modal-content">
			<div class="modal-header">
			  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <h4 class="modal-title" id="myModalLabel{{$s->id}}">更新银行信息</h4>
			</div>
			<div class="modal-body">
					<form class="form-horizontal" method="POST" action="{{url('virtual/accountBank')}}">
				<div class="form-group">
							  <label for="account" class="col-sm-2 control-label">银行卡号</label>
							  <div class="col-sm-10">
							  <input type="input" name="account" class="form-control" id="account" placeholder="银行卡号" value="{{$s->account}}">
							  </div>
				</div>
				<div class="form-group">
						<label for="bank" class="col-sm-2 control-label">银行名称</label>
						<div class="col-sm-10">
						<input type="input" name="bank" class="form-control" id="bank" placeholder="银行名称" value="{{$s->bank}}">
						</div>
						</div>
				<div class="form-group">
					<label for="real_name" class="col-sm-2 control-label">持卡人</label>
					<div class="col-sm-10">
					<input type="input" name="real_name" class="form-control" id="real_name" placeholder="持卡人姓名" value="{{$s->real_name}}">
					</div>
					</div>

					<div class="form-group">
						<label for="sub_branch" class="col-sm-2 control-label">分行名称</label>
						<div class="col-sm-10">
						<input type="input" name="sub_branch" class="form-control" id="sub_branch" placeholder="银行分行名称" value="{{$s->sub_branch}}">
						</div>
						</div>

						<div class="form-group">
							<label for="amount" class="col-sm-2 control-label">余额提现</label>
							<div class="col-sm-10">
							<input type="input" name="amount" class="form-control" id="amount" placeholder="银行分行名称" value="{{$s->amount}}">
							</div>
							</div>

						<input type="text" hidden value="{{$s->id}}" name="id">

						{{csrf_field()}}
			</div>
			<div class="modal-footer">
			 	 <input type="submit" class="btn btn-primary"></button>
					</form>
			</div>
		  </div>
		</div>
	  </div>

							@endforeach
						@endif
					</tbody>
				</table>
			</div>
		</div>		
	
	</div>
	<div class="box-footer">

	</div>
</div>
@endsection

@section('js')
<script src="{{asset('vendor/layer.js')}}"></script>




{{-- <script>
    $('div.alert').delay(3000).fadeOut(350);
</script> --}}
	{{-- @include('common/datatables_js')
	@include('common/daterangepicker')

	<script>
		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		})
			$(function(){
				$('#users-table').DataTable({
					order : [[0,'desc']],
					procession: true,
					serverSide: true,
					pageLength : 100,
					language :{
						url : "{{url('virtual/datatabslesZh')}}"
					},
          ajax:{
            url : '{!! route('memberData.data') !!}',
            data:function(d){
				d.time = $("#reservation1").val();
            }
          },
					columns:[
						{data: 'id',name:'id'},
					]
				});
			});
   $('#search-form').on('submit',function(e){
        oTable.draw();

        //AJAX 显示对应的搜索的格式化信息在右边
        e.preventDefault();
   });

	</script> --}}
@endsection