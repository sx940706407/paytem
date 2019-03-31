<?php

namespace App\Models\Third;

use Illuminate\Database\Eloquent\Model;

class ShopModels extends Model
{
    protected $table = 'third_shop';

    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'id','nick_name','shop_name','mobile','passwd','trade_passwd','app_id','app_secret','money'
    ];
}
