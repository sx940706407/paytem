<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAmountToVirtualCurrencyUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('virtual_currency_user', function (Blueprint $table) {
            $table->unsignedInteger('amount')->comment('提现的金额')
                    ->default(100)->after('sub_branch');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('virtual_currency_user', function (Blueprint $table) {
            //
        });
    }
}
