<?php

namespace App\Http\Controllers\system;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function add()
    {
    	return view('system.shop.add');
    }
    public function manager()
    {
    	return view('system.shop.manager');
    }
    public function js()
    {
    	return view('system.shop.js');
    }    
    public function realName()
    {
    	return view('system.shop.realName');
    }
    public function api()
    {
    	return view('system.shop.api');
    }
          
}
