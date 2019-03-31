<?php

namespace App\Http\Controllers\system;

use Illuminate\Http\Request;

class NotiyController extends Controller
{
    public function notiy()
    {
    	return view('system.other.notiy');
    }
    public function message()
    {
    	return view('system.other.message');
    }
    public function quesstion()
    {
    	return view('system.other.quesstion');
    }


}
