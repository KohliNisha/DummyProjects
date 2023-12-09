<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScPieVideoSearchLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sc_pie_video_search_log', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('search_keyword',255)->nullable();
            $table->bigInteger('search_by')->unsigned()->default(0);
            $table->dateTime('search_at')->nullable();
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
        Schema::dropIfExists('sc_pie_video_search_log');
    }
}
