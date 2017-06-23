<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Scourses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Scourses',function(Blueprint $table){
            $table->unsignedInteger('Cid');
            $table->unsignedInteger('Tid');
            $table->primary(['Cid','Tid']);

            $table->tinyInteger('ScmarkObjective');
            $table->tinyInteger('ScmarkSubjective');
            $table->string('Scmark',5);
            $table->tinyInteger('Scterm');//课程所修学期，1-7
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
        Schema::dropIfExists('Scourses');
    }
}
