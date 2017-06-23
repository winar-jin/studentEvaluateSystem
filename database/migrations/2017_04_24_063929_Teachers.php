<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Teachers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Teachers',function(Blueprint $table){
            $table->unsignedInteger('Tid');
            $table->primary('Tid');

            $table->string('Tname',20);
            $table->string('Tpassword');
            $table->string('Tsex',5);
            $table->string('Tphone',15);
            $table->string('Tapartment',20);
            $table->string('Sphoto');
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
        Schema::dropIfExists('Teachers');
    }
}
