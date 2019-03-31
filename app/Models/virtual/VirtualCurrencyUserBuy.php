<?php

namespace App\Models\virtual;

use Illuminate\Database\Eloquent\Model;

class VirtualCurrencyUserBuy extends Model
{
    protected $table = 'virtual_currency_user_buy';

    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
