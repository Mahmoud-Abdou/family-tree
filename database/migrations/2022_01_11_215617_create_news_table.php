<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id');
            $table->foreignId('city_id')->nullable()->default(null);
            $table->string('title');
            $table->text('body');
            $table->foreignId('category_id');
            $table->foreignId('image_id')->nullable();
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
        Schema::dropIfExists('news');
    }
}
