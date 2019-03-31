<?php

namespace App\Models\Third;

use Illuminate\Database\Eloquent\Model;

class PayInfoModels extends Model
{
    protected $table = 'third_pay_info';

    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
}
