<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('sender_id');
            $table->bigInteger('recipient_id');
            $table->smallInteger('message_id')->default(0)->comment('here will be notification type');
            $table->bigInteger('entity_id');
            $table->string('url',555)->nullable();
            $table->string('message',1255)->nullable();
            $table->smallInteger('type')->default(0);
            $table->smallInteger('is_read')->default(0)->comment('0 unread, 1 Read');
            $table->smallInteger('is_read_on_click')->default(0)->comment('0 not clicked, 1 clicked');
            $table->smallInteger('is_read_admin')->default(0)->comment('0 not read, 1 for read');
            $table->smallInteger('status')->default(0);
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
        Schema::dropIfExists('notifications');
    }
}
