<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLiveFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_feeds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('content_url');
            $table->string('thumb_url');
            $table->string('country_code');
            $table->string('region_code')->nullable();
            $table->string('city_name');
            $table->double('latitude');
            $table->double('longitude');
            $table->string('type');            
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
        Schema::drop('live_feeds');
    }
}
