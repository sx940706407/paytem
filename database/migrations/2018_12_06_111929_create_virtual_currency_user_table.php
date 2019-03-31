<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVirtualCurrencyUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('virtual_currency_user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username',255)->comment('虚拟币帐号名称');
            $table->string('mercode',255)->comment('开户名');
            $table->string('address',255)->comment('钱包地址');
            $table->double('balance',15,4)->comment('钱包余额,带有精度的');
            $table->double('frozen_amount',15,4)->nullable()->comment('冰冻余额,带有精度的');
            $table->string('coin_code',255)->comment('钱包地址对应虚拟币种类有ETH==');
            $table->tinyInteger('user_type')->comment('类型 1为会员 2 为商户');
            $table->integer('game_id')->comment('游戏ID对应虚拟币帐号,一天只能购买三次的虚拟币');
            
            $table->string('account',100)->nullable()->comment('银行卡号');
            $table->string('bank',100)->nullable()->comment('银行名称');
            $table->string('real_name',100)->nullable()->comment('持卡人姓名');
            $table->string('sub_branch',100)->nullable()->comment('银行支行名称');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('virtual_currency_user');
    }
}
