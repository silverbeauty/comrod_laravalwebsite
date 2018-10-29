<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIpFieldInUserWatchedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_watched', function (Blueprint $table) {
            $table->integer('user_id')->nullable()->change();
            $table->string('ip')->nullable()->index()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_watched', function (Blueprint $table) {
            $table->dropColumn('ip');
        });
    }
}
