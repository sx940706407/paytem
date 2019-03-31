<?php

namespace App\Models\Third;

use Illuminate\Database\Eloquent\Model;

class ShopMoney extends Model
{
    protected $table = 'third_shop_money';

    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'id','shop_id','before_money','money','after_money','active'
    ];
}
