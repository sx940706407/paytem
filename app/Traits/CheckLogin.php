<?php
namespace App\Traits;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

// use Gregwar\Captcha\CaptchaBuilder;
// use Gregwar\Captcha\PhraseBuilder;
use App\Models\Server\ActiveLogin;
/**
 * 记录登录日志，记录登录次数.限制登录，验证码
 */
trait CheckLogin
{
    /**
     * 记录登录的错误的次数 function
     *
     * @param [type] $ip
     * @return void
     */
    public function ipAccessRestrictions($ip)
    {
        if (!Cache::has($ip)) {
            Cache::put('LoginLimit:'.$ip, 1, Carbon::now()->addMinutes(5));
        }
        Cache::increment('LoginLimit:'.$ip);
    }

    /**
     * 记录登录情况--失败与成功 function
     *
     * @param [type] $request
     * @param boolean $status
     * @return void
     */
    public function agentAccessLogin($request, $status = true)
    {
        $ip = $request->getClientIp();
        $ua = $_SERVER['HTTP_USER_AGENT'];
        $data = [
            'email'	=> $request->phone,
            'password'	=> $status == true ? '*******' : $request->password,
            'captcha'	=> '',
            'type'	=> $status == true ? 1 : 0,
            'ip'	=> $ip,
            'ua'	=> $ua,
            'captcha'   => 'xxxxxx',
            'status'=> $status == true ? 1 : 0,
            'user_id'   => '0',
        ];
        ActiveLogin::create($data);
    }
    /**
     * 统一生成的验证码处理 function
     *
     * @param string $captchaName
     * @return void
     */
    public function agentCaptcha($captchaName = 'captchaLogin')
    {
        $phrase = new PhraseBuilder;
        // 设置验证码位数
        $code = $phrase->build(4);

        $builder = new CaptchaBuilder($code, $phrase);
        $builder->build($width = 125, $height = 45);

        header('Cache-Control: no-cache, must-revalidate');
        header('Content-type: image/jpeg');
        $builder->output();

        session($captchaName, $builder->getPhrase());
    }
}
