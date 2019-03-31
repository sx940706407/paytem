<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVirtualCurrencyUserBuyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('virtual_currency_user_buy', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('game_id')
                ->comment('对应的创建用户的游戏ID,只能买币不能卖币');
            $table->string('mercode',255)
                ->comment('开户名');
            $table->tinyInteger('type')
                ->comment('请求类型 0-查看订单，1-买币，2-卖币');
            $table->string('coin',255)
                ->comment('虚拟币种类');
            $table->double('amount',15,4)
                ->comment('购买数量,100起步')->default(100);
            $table->string('order_id',100)->comment('购买币的订单编号,用于后续查询');
            $table->string('pay_methods',255)->comment('购买当前币的支付方式,默认4种都提供');
            $table->tinyInteger('State1')->nullable()
                ->comment('订单状态 0-初始创建 1-收款方未收款 2-收款方已收款（即订单完成）3-被投诉关闭 4-订单关闭 9-验证失败而关闭 10-等待审核');
            $table->tinyInteger('State2')->nullable()->comment('支付状态 1-未支付 2-已支付');
            $table->date('pay_time')->nullable()->comment('交易创建时间');
            $table->string('Remark')->nullable()->comment('备注,参考号一定要有');
            $table->double('price',15,4)->nullable()->comment('价格,带有小数双精度存');
            $table->text('return_content')->nullable()
                ->comment('回调的内容存放.平台随意更换字段');
            $table->tinyInteger('State')->nullable()
                ->comment('状态 1：待处理，2：处理中，3：已提交， 4：成功，5：失败');
            $table->tinyInteger('notice_type')->nullable()
                ->comment('交易类型 1：商户充币，2：商户提币，3：商户转出，4：用户充币，5：用户提币，6：用户转出，7：托管平台手续费');
            $table->double('fee',15,4)->nullable()
                ->comment('手续费');

            $table->string('FromAddr',255)->nullable()
                    ->comment('交易来源地址');
            $table->string('ToAddr',255)->nullable()
                    ->comment('交易目标地址');
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
        Schema::dropIfExists('virtual_currency_user_buy');
    }
}
