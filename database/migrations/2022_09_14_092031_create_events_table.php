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
            $table->foreign('id_citizen')->references('id')->on('citizens');
            $table->string('full_name');
            $table->date('date_birth');
            $table->string('who_noticed');
            $table->string('where_noticed');
            $table->dateTime('detection_date');
            $table->string('user');
            $table->integer('id_user');
            $table->timestamps();
        });
        Schema::table('records', function (Blueprint $table) {
            $table->biginteger('id_event')->nullable()->unsigned();
            $table->foreign('id_event')->references('id')->on('events');
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
