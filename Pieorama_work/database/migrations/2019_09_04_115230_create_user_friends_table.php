<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFriendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_friends', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('friend_id')->nullable();
            $table->dateTime('request_date')->nullable();
            $table->smallInteger('is_approved')->default(0)->comment('0=>NotApproved, 1=>Approved');
            $table->dateTime('approved_date')->nullable();
            $table->smallInteger('is_active')->default(0)->comment('0=>Notactive, 1=>active');
            $table->string('comments',255)->nullable();
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
        Schema::dropIfExists('user_friends');
    }
}
