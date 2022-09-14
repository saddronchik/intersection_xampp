<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_citizen')->unsigned();
            $table->foreign('id_citizen')->references('id')->on('citizens')->restrictOnDelete();
//            $table->string('citizen_name');
//            $table->date('citizen_birth');
            $table->string('who_noticed');
            $table->string('where_noticed');
            $table->dateTime('detection_date');
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
        Schema::dropIfExists('events');
    }
}
