<?php

namespace App\Http\Controllers\system;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SettingController extends Controller
{
    public function core()
    {
    	return view('system.seting.core');
    }

    public function pay()
    {
    	return view('system.seting.pay');
    }
    public function email()
    {
    	return view('system.seting.email');
    }

    public function sms()
    {
    	return view('system.seting.sms');
    }

    public function blackPay()
    {
    	return view('system.seting.blackPay');
    }
}
