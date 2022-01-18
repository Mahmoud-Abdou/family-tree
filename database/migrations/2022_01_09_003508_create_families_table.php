<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('families', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->foreignId('father_id')->nullable()->index();
            $table->foreignId('mother_id')->nullable();
            $table->integer('children_count')->default(0);
            $table->foreignId('gf_family_id')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->json('family_tree')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('families');
    }
}
