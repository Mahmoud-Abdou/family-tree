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
            $table->foreignId('owner_id');
            $table->foreignId('city_id')->nullable();
            $table->string('title');
            $table->text('body');
            $table->foreignId('image_id');
//            $table->enum('type', config('custom.categories'))->nullable();
            $table->foreignId('category_id');
            $table->boolean('approved')->default(false);
            $table->foreignId('approved_by')->default(null);
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