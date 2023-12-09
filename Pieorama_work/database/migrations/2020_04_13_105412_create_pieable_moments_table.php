<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePieableMomentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pieable_moments', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->unsigned()->default(0);
            $table->foreign('user_id')->references('id')->on('users');
            $table->smallInteger('file_type')->default(0)->comment('1=>Image, 2=>Audio, 3=>Video');
            $table->string('title',1000)->nullable();
            $table->longText('piable_description')->nullable();
            $table->text('comment_note')->nullable();
            $table->text('library_tags')->nullable();
            $table->string('file_name',1000)->nullable();
            $table->string('video_thumbnail_file_path',555)->nullable();
            $table->string('original_video_path',555)->nullable();            
            $table->string('file_mime_type',1000)->nullable();
            $table->string('file_size',255)->nullable();
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->smallInteger('status')->default(0)->comment('0=>Active, 1=>Inactive');
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
        Schema::dropIfExists('pieable_moments');
    }
}
