<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Marks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Marks',function(Blueprint $table){
            $table->increments('Mid');
            $table->unsignedInteger('Sid');
            $table->foreign('Sid')
                  ->references('Sid')->on('Students');
            $table->tinyInteger('Mterm');
            $table->string('Mcourse',5);
            $table->tinyInteger('Mactivity');
            $table->integer('McmSumScore');
            $table->tinyInteger('McmSum');
            $table->string('MclassMates',5);
            $table->tinyInteger('Mpe');
            $table->tinyInteger('MlawPolicy');
            $table->string('Mscore',5);
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
        Schema::dropIfExists('Marks');
    }
}
