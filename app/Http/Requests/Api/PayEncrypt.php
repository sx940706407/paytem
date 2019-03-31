<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class PayEncrypt extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {   
        //app_id,app_secret,body,call,paymethod(wx,zfb,qq,unionpay),totalfee,third
        return [
            'dddd'  => 'required',   
            // 'body'    => 'required',
            // 'call'    => 'required',
            // 'paymethod' => 'required',
            // 'totalfee'  => 'required',
            // 'third' => 'required',
        ];
    }
    /**
     * [messages 自定义错误消息]
     * @return [type] [description]
     */
    public function messages()
    {
        return [
            'dddd.required' => 'A dddd is required',
        ];
    }
}
