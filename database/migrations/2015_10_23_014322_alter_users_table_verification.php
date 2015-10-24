<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersTableVerification extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function(Blueprint $table) {            
            $table->string('mobileno', 15)->nullable();
            $table->string('activation_code', 100)->nullable();
            $table->tinyInteger('status')->default(1);
            $table->tinyInteger('verify')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('mobileno');
            $table->dropColumn('activation_code');
            $table->dropColumn('status');
            $table->dropColumn('verify');
        });
    }
}
