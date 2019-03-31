<?php

namespace App\Models\Third;

use Illuminate\Database\Eloquent\Model;

class BankDetail extends Model
{
    protected $table = 'third_bank_detail';

    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'id','bank_no','province','city','branchname','number','bankname','status','content'
    ];
}
