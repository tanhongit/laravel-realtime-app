<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function ($table) {
            $table->unsignedBigInteger('conversation_id')->default(0)->change();
        });
        Schema::table('conversation_users', function ($table) {
            $table->unsignedBigInteger('conversation_id')->default(0)->change();
            $table->unsignedInteger('sender_id')->default(0)->change();
            $table->unsignedInteger('receiver_id')->default(0)->change();
        });
        Schema::table('user_messages', function ($table) {
            $table->unsignedInteger('sender_id')->default(0)->change();
            $table->unsignedInteger('receiver_id')->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
