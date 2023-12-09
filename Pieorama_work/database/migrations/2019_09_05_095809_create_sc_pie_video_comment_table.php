<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScPieVideoCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sc_pie_video_comment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('video_id')->unsigned()->default(0);
            $table->foreign('video_id')->references('id')->on('sc_pie_video');
            $table->text('video_file_path')->nullable();
            $table->text('comment_text')->nullable();
            $table->string('commentd_by_username')->nullable();
            $table->bigInteger('comment_by')->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('parent_id')->nullable();
            $table->smallInteger('is_deleted')->default(0)->comment('0=>Notdeleted, 1=>Deleted');
            $table->dateTime('deleted_at')->nullable();
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
        Schema::dropIfExists('sc_pie_video_comment');
    }
}
