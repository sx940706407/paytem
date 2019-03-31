@extends('virtual/layout/master')

@section('content-header')
      <h1>
        购买记录
        <small>buyList</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Agent</a></li>
        <li class="active">buyList</li>
      </ol>	
@endsection

@section('content')
<div class="box">
	<div class="box-header">
    <form class="form-inline" method="POST" action="{{url('virtual/buyList')}}"  target= "_blank" class="pull-left">
                <div class="form-group">
                  <label for="game_id">ID==>币种</label>

                  <select  class="form-control" name="game_id">
                        @if($user)
                            @foreach($user as $u)
                  <option value="{{$u->game_id}}">{{$u->game_id}}==>{{$u->coin_code}}</option>
                            @endforeach
                        @endif
                      </select>
                </div>
                <div class="form-group">
                  <label for="num">买入数量</label>
                  <input type="text" class="form-control" id="num" name="num" placeholder="100起步 对应币种">
                </div>
                    {{csrf_field()}}
                <button type="submit" class="btn btn-default">购买</button>

                <p class="pull-right text-danger">
                        1.单个ID当天错误购买次数超过三次,则会被拒绝购买!
                        2.默认为DC币 (备选USDX) 其它币种ETH,BTC,LTC,BCB波动较大!
                  </p>

              </form>
	</div>

	<div class="box-body table-responsive" id="form_do">
		<div class="row">
			<div class="col-md-12">
				<table class="table tale-bordered table-bordered table-hover table-condensed">
					<thead>
							<tr>
								<th>序列</th>
								<th>游戏ID</th>
								<th>类型</th>
								<th>币种</th>
								<th>金额(元)</th>
								<th>订单编号</th>
								<th>状态1</th>
								<th>状态2</th>
								<th>备注(回调)</th>
								<th>币种当前价格</th>
								<th>时间</th>
							</tr>
                    </thead>
                    
                    <tbody>
                        @foreach($virtual as $v)
                        <tr>
                        <td>{{$v->id}}</td>
                            <td>{{$v->game_id}}</td>
                            <td>
                                @if($v->type == 1)
                                    买入
                                @else
                                   <span class="text-success">提现</span>  
                                @endif
                            </td>
                            <td>{{$v->coin}}</td>
                            <td>{{$v->amount}}</td>
                            <td>{{$v->order_id}}</td>
                            <td>@if($v->State1 == 2)
                                    -收款方已收款（即订单完成）
                                @else 
                                {{$v->State1}}</td>
                                @endif
                            <td>
                                @if($v->State2 == 2)
                                    <span class="text-danger">已支付</span> 
                                @else
                                    未支付
                                @endif
                            </td>
                            <td>{{$v->Remark}}</td>
                            <td>{{$v->price}}</td>
                            <td>{{$v->created_at}}</td>
                        </tr>
                        @endforeach
                    </tbody>
				</table>
			</div>
		</div>		
	</div>
	<div class="box-footer">
        {{$virtual->links()}}
    </div>
    
    <p>
        状态1 0-初始创建 1-收款方未收款 2-收款方已
        收款（即订单完成）3-被投诉关闭 4-订单关闭 9-验证
        失败而关闭 10-等待审核
    
    </p>

</div>

@endsection


@section('js')
@endsection