<?php

namespace App\Models\Third;

use Illuminate\Database\Eloquent\Model;

class BankInfo extends Model
{
    protected $table = 'third_bank_info';

    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'id','third','channel','payType','body','subject','order_id','platform_order','pay_status','third_pay_status','notify_url','pay_shop_id','pay_money','pay_formality','pay_channel_id','pay_time','pay_done_time','pay_callback_content','pay_data','pay_query_count','pay_notify_time','pay_notify_count'
    ];
}
