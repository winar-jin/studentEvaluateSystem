<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Courses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('Courses',function(Blueprint $table){
            $table->unsignedInteger('Cid');
            $table->primary('Cid');
            
            $table->unsignedInteger('Tid');
            $table->foreign('Tid')
                  ->references('Tid')->on('Teachers');
            $table->string('Cname');
            $table->tinyInteger('Ccredit');
            $table->tinyInteger('Cterm');//课程所在学期，1为上学期，2为下学期
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
        Schema::dropIfExists('Courses');
    }
}
