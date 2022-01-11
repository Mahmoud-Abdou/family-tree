<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('persons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->index();
            $table->string('first_name', 100)->index();
            $table->string('father_name', 100)->index();
            $table->string('grand_father_name', 100)->index()->nullable();
            $table->string('surname', 100)->index();
            $table->string('prefix', 10)->nullable();
            $table->string('job', 100)->nullable();
            $table->string('bio')->nullable();
            $table->enum('gender', ['male', 'female']);
            $table->string('photo', 2048)->nullable();
            $table->boolean('has_family')->default(false);
//            $table->foreignId('family_id');
            $table->foreignId('family_id')->nullable();
//            $table->foreignId('relation_id'); // relation type
//            $table->foreignId('relation_id')->nullable();
            $table->enum('relation', ['husband', 'wife', 'father', 'mother', 'sister', 'brother', 'son', 'daughter', 'Breastfeeding-Brother'])->nullable();
            $table->string('address')->nullable();
            $table->boolean('is_live')->default(true);
            $table->dateTime('birth_date')->nullable();
            $table->string('birth_place', 100)->nullable();
            $table->dateTime('death_date')->nullable();
            $table->string('death_place', 100)->nullable();
            $table->boolean('verified')->default(true);
            $table->string('symbol')->nullable();
            $table->string('color')->nullable();
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
        Schema::dropIfExists('persons');
    }
}
