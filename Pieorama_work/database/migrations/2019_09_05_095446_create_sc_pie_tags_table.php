<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScPieTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sc_pie_tags', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('video_id')->unsigned()->default(0);
            $table->foreign('video_id')->references('id')->on('sc_pie_video');
            $table->string('tag_text',255)->nullable();
            $table->smallInteger('is_deleted')->default(0)->comment('0=>Notdeleted, 1=>Deleted');
            $table->dateTime('deleted_at')->nullable();
            $table->bigInteger('created_by')->nullable();
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
        Schema::dropIfExists('sc_pie_tags');
    }
}
