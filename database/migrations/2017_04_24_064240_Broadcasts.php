<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Broadcasts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Broadcasts',function(Blueprint $table){
            $table->increments('Bid');
            $table->string('Btime');//公告时间
            $table->string('Btitle',50);//公告标题
            $table->string('Bphoto');//配图
            $table->string('Blink');//连接地址
            $table->tinyInteger('Btype');//公告类型
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Broadcasts');
    }
}
