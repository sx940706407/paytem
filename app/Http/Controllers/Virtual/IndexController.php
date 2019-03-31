<?php

namespace App\Http\Controllers\Virtual;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Services\Virtualcurrency;

use App\Models\virtual\VirtualCurrencyUser;
use App\Models\virtual\VirtualCurrencyUserBuy;

class IndexController extends Controller
{

    public $virtual;

    public function __construct(Virtualcurrency $virtual)
    {
        $this->virtual = $virtual;
    }
    /**
     * 展示会员 与 商户的显示  function
     *
     * @param Request $request
     * @return void
     */
    public function index(Request $request)
    {
        $shop = VirtualCurrencyUser::where('user_type',2)->get();
        $member = VirtualCurrencyUser::where('user_type',1)->paginate(20);

        return view('virtual.Index.index',compact('shop','member'));
    }
    /**
     * 刷新余额 function
     *
     * @param Request $request
     * @return void
     */
    public function refreshBalance(Request $request)
    {
        $this->virtual->GetBalance('moab',2); 
        sleep(1);
        return redirect('virtual/index');
    }
    /**
     * 更新对应币种的银行卡 function
     *
     * @param Request $request
     * @return void
     */
    public function accountBank(Request $request)
    {
        $param = $request->all();
        $data = [
            'account'   => $param['account'],
            'bank'   => $param['bank'],
            'real_name'   => $param['real_name'],
            'sub_branch'   => $param['sub_branch'],
            'amount'   => $param['amount'],
        ];
        $virtual = VirtualCurrencyUser::where('id',$param['id'])->update($data);
        \Log::info('accountBank======>',['data'=> $data]);

        if ($virtual) {
            return back()->with('success','更新银行卡信息成功');
        }
    }
    /**
     * 提现操作 function
     *
     * @return void
     */
    public function withdraw(Request $request)
    {
        $virtual = VirtualCurrencyUser::where('id',$request->id)->first();
        if ($virtual) {
            if ($virtual->balance < 100 ) {
                 return back()->with('success','金额小于100');
            }
            if (empty($virtual->account) 
                && empty($virtual->bank)
                && empty($virtual->real_name)
                && empty($virtual->sub_branch)) {
                return back()->with('success','银行卡信息不能为空!');
            }
            //卖币操作..
            $resutl = $this->virtual->login($virtual->game_id,$virtual->amount,'',2,$virtual->coin_code);
            if ($resutl != 'failed' && $resutl['Success'] == true) {
                return redirect()->away($resutl['Data']['Url'] .'/'.$resutl['Data']['Token']);
                //  header("Location:".$resutl['Data']['Url'] .'/'.$resutl['Data']['Token']);
            }  else {
                return back()->with('success','服务错误,请刷新页面');
            }
        }
        return back()->with('success','未知ID,请按钮点击');
    }
    /**
     * 购买记录 function
     *
     * @return void
     */
    public function buyList()
    {
        $virtual = VirtualCurrencyUserBuy::orderBy('id','DESC')->paginate(20);
        $user = VirtualCurrencyUser::orderBy('id','DESC')
                                ->select('game_id','coin_code')
                                ->where('user_type',1)
                                ->limit(100)
                                ->get();
        return view('virtual.Index.buy',compact('virtual','user'));
    }
    public function buyListPost(Request $request)
    {
        $param = $request->all();
        if ($param['num'] > 100) {
            return back()->with('success','金额小于100');
        }
        $virtual = VirtualCurrencyUser::where('game_id',$param['game_id'])->first();
        if ($virtual) {
            $resutl = $this->virtual->login($virtual->game_id,$param['num']);
            if ($resutl != 'failed' && $resutl['Success'] == true) {
                return redirect()->away($resutl['Data']['Url'] .'/'.$resutl['Data']['Token']);
                //  header("Location:".$resutl['Data']['Url'] .'/'.$resutl['Data']['Token']);
            }
        }
        return back()->with('success','未知ID,请按钮点击');

    }

}
