<?php

namespace App\Http\Controllers\Shop;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Cache,Log,DB;

class IndexController extends Controller
{
    public function index()
    {
    	return view('shop.index.index');
    }

    public function user()
    {
    	return view('shop.index.user');
    }

    public function order()
    {
    	return view('shop.index.order');
    }

    public function orderData()
    {
    	$data  = [
    		0	=> [
    			'order_id'	=> 'xxxx',
    			'order_time' => '2018-08-08 15:55:55',
    			'order_channel'	=> 'wechat',
    			'order_money'	=> 111,
    			'order_me'	=> 222,
    			'order_status'=> '<span class="btn btn-danger btn-xs">失败</span>'
    		],    		1	=> [
    			'order_id'	=> 'xxxx',
    			'order_time' => '2018-08-08 15:55:55',
    			'order_channel'	=> 'wechat',
    			'order_money'	=> 111,
    			'order_me'	=> 222,
    			'order_status'=> '<span class="btn btn-danger btn-xs">失败</span>'
    		],    		2	=> [
    			'order_id'	=> 'xxxx',
    			'order_time' => '2018-08-08 15:55:55',
    			'order_channel'	=> 'wechat',
    			'order_money'	=> 111,
    			'order_me'	=> 222,
    			'order_status'=> '<span class="btn btn-danger btn-xs">失败</span>'
    		],    		3	=> [
    			'order_id'	=> 'xxxx',
    			'order_time' => '2018-08-08 15:55:55',
    			'order_channel'	=> 'wechat',
    			'order_money'	=> 111,
    			'order_me'	=> 222,
    			'order_status'=> '<span class="btn btn-danger btn-xs">失败</span>'
    		],
    	];

    	$data = collect($data);

        $datatables = DataTables::of($data)
        	->escapeColumns([])
        ;

        return $datatables->make(true);
    }


    public function payChannel()
    {
    	return view('shop.index.payChannel');
    }


    public function api()
    {
    	return view('shop.index.api');
    }

    public function js()
    {
    	return view('shop.index.js');
    }

    public function df()
    {
    	return view('shop.index.df');
    }

    public function bz()
    {
    	return view('shop.index.bz');
    }
}
