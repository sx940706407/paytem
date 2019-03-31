<?php

namespace App\Http\Controllers\system;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index()
    {
    	return view('system.index.index');
    }

}
