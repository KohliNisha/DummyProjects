<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id');
            $table->tinyInteger('due_date_notification')->default(0);
            $table->tinyInteger('loan_notification')->default(0);
            $table->tinyInteger('personal_notification')->default(0);
            $table->tinyInteger('email_notification')->default(0);
            $table->tinyInteger('support_notification')->default(0);
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
        Schema::dropIfExists('user_settings');
    }
}
