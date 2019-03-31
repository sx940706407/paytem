<?php

namespace App\Http\Controllers\system;

use Illuminate\Http\Request;

class RelatedController extends Controller
{
    public function order()
    {
    	return view('system.related.order');
    }

    public function js()
    {
    	return view('system.related.js');
    }
    public function black()
    {
    	return view('system.related.black');
    }


}
