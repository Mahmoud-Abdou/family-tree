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
            $table->string('title')->index();
            $table->text('body');
            $table->foreignId('image_id');
//            $table->enum('type', config('custom.categories'))->nullable();
//            $table->bigInteger('event_date');
            $table->dateTime('event_date')->default(now());
            $table->foreignId('category_id');
            $table->boolean('approved')->default(false);
            $table->foreignId('approved_by')->nullable()->default(null);
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
