<?php

namespace App\Http\Controllers\Virtual;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\CheckLogin;
use Config,Cache;

class LoginController extends Controller
{
    use CheckLogin;

    public function login(Request $request)
    {
        if ($request->session()->has('system_admin')) {
            return  redirect('virtual/index');
        }
        return view('virtual.login');
    }

    public function loginDo(Request $request)
    {
		$LoginLimit = 'LoginLimit:'.$request->getClientIp();
		$limit = Cache::get($LoginLimit);
		if ($limit >= 6) {
			return response()->json(Config::get('error.101'));
		} 
        $account = 'admin';
        $password = 'chohZuPuuZophohV2mee';

        if ($request->phone !=  $account || $request->password != $password) {

            $this->ipAccessRestrictions($request->getClientIp());

            return response()->json(Config::get('error.101'));
        }
        $request->session()->put('system_admin', $account);

        return response()->json(Config::get('error.200'));
    }
}
