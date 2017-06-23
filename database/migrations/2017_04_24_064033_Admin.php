<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Admin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Admin',function(Blueprint $table){
            $table->unsignedInteger('Aid');
            $table->primary('Aid');
            
            $table->string('Aname',20);
            $table->string('Apassword');
            $table->string('Asex',5);
            $table->string('Aphone',15);
            $table->string('Aphoto');
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
        Schema::dropIfExists('Admin');
    }
}
