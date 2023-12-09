<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVideoLargeThumbnailFilePathToScPieVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sc_pie_video', function (Blueprint $table) {
            $table->string('video_large_thumbnail_file_path',555)->nullable()->after('video_thumbnail_file_path');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sc_pie_video', function (Blueprint $table) {
            //
        });
    }
}
