<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password', 60)->nullable();
            $table->string('gender')->nullable();
            $table->char('country_code')->nullable();
            $table->integer('city_id');
            $table->date('birth_day')->nullable();
            $table->string('license_plate')->nullable();
            $table->char('license_plate_country_code')->nullable();
            $table->boolean('signup_friendly_alerts')->default(false);
            $table->boolean('signup_parental_alerts')->default(false);
            $table->boolean('verified_email')->default(false);
            $table->string('email_verification_token', 60)->nullable();
            $table->string('avatar')->nullable();
            $table->string('avatar_social')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('twitter_id')->nullable();
            $table->string('pinterest_id')->nullable();
            $table->string('vimeo_id')->nullable();
            $table->string('google_id')->nullable();
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
