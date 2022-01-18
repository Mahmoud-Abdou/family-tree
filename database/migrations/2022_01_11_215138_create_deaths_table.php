<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeathsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deaths', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id');
            $table->foreignId('family_id');
            $table->string('title');
            $table->text('body');
            $table->foreignId('image_id')->nullable();
            $table->dateTime('date');
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
        Schema::dropIfExists('deaths');
    }
}
