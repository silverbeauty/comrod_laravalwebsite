<?php

use Illuminate\Database\Migrations\Migration;

class CreateLanguagesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('translator_languages', function ($table) {
            $table->increments('id');
            $table->string('country_code')->unique();
            $table->string('locale', 6)->unique();
            $table->string('name', 60)->unique();
            $table->string('url');
            $table->string('facebook');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('languages');
    }

}
