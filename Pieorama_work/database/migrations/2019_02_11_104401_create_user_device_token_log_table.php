<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDeviceTokenLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_device_token_log', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id');
            $table->string('device_token',255)->nullable();
            $table->string('device_os',100)->nullable();
            $table->smallInteger('is_deleted')->default(0)->comment('0 not delete, 1 for deleted');
            $table->dateTime('deleted_at')->nullable();            
            $table->integer('created_by')->default(0);
            $table->integer('updated_by')->default(0);
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
        Schema::dropIfExists('user_device_token_log');
    }
}
