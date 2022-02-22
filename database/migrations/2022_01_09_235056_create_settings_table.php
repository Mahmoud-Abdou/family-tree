<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('app_title_ar');
            $table->string('app_title_en')->nullable();
            $table->longText('app_description_ar');
            $table->longText('app_description_en')->nullable();
            $table->longText('app_about_ar');
            $table->longText('app_about_en')->nullable();
            $table->string('app_contact_ar');
            $table->string('app_contact_en')->nullable();
            $table->longText('app_terms_ar');
            $table->longText('app_terms_en')->nullable();
            $table->string('app_logo');
            $table->string('app_icon')->nullable();
            $table->string('family_tree_image')->nullable();
            $table->string('family_name_ar');
            $table->string('family_name_en')->nullable();
            $table->integer('default_user_role')->default(3);
            $table->boolean('app_registration')->default(false);
            $table->boolean('app_first_registration')->default(false);
            $table->boolean('app_comments')->default(true);
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
        Schema::dropIfExists('settings');
    }
}
