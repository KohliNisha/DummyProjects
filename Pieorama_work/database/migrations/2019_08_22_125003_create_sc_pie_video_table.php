<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScPieVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sc_pie_video', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('video_title',255)->nullable();            
            $table->longText('video_description')->nullable(); 
            $table->text('comment_note')->nullable();
            $table->string('video_file_path',255)->nullable();
            $table->string('video_thumbnail_file_path',555)->nullable();
            $table->string('video_animated_file_path',555)->nullable();
            $table->bigInteger('pie_audio_id')->nullable();
            $table->bigInteger('pie_channel_id')->nullable();
            $table->smallInteger('is_publish')->default(0)->comment('0=>NotPublish, 1=>Publish');
            $table->smallInteger('access_scope')->default(0);
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->smallInteger('public_available')->default(0)->comment('0=>NotPublic, 1=>Public');
            $table->smallInteger('searchable')->default(0)->comment('0=>No, 1=>yes'); 
            $table->smallInteger('is_deleted')->default(0)->comment('0=>Notdeleted, 1=>Deleted');
            $table->dateTime('deleted_at')->nullable();
            $table->smallInteger('status')->default('0')->comment('0=>Not activate, 1=> Activated');
            $table->dateTime('publish_date')->nullable();
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
        Schema::dropIfExists('sc_pie_video');
    }
}
