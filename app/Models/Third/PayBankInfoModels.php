<?php

namespace App\Models\Third;

use Illuminate\Database\Eloquent\Model;

class PayBankInfoModels extends Model
{
    protected $table = 'third_pay_bank_info';

    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'id','pay_data','state_data','pay_shop_id','order_id','platform_order','pay_status','pay_third_status','notifyurl','pay_notify_count','pay_notify_time'
    ];
}
