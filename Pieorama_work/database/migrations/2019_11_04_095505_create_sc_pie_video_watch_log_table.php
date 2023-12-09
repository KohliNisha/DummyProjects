<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScPieVideoWatchLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sc_pie_video_watch_log', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('video_id')->unsigned()->default(0);
            $table->foreign('video_id')->references('id')->on('sc_pie_video');
            $table->bigInteger('user_id')->nullable();
            $table->smallInteger('is_delete')->default(0)->comment('0=>UnDelete, 1=>Delete');
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
        Schema::dropIfExists('sc_pie_video_watch_log');
    }
}
