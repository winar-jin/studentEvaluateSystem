<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Students extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Students',function(Blueprint $table){
            $table->unsignedInteger('Sid');
            $table->primary('Sid');

            $table->string('Sname',20);
            $table->string('Spassword');
            $table->string('Ssex',5);
            $table->string('Sclass',20);
            $table->string('Sgrade',10);
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
        Schema::dropIfExists('Students');
    }
}
