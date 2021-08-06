<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEmailInterestedCake extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('email_interested_cake', function (Blueprint $table) {
            $table->id('email_interested_cake_id');
            $table->unsignedBigInteger('cake_id_fk');
            $table->string('email');
            $table->foreign('cake_id_fk')->references('cake_id')->on('cake');
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
        Schema::dropIfExists('email_interested_cake');
    }
}
