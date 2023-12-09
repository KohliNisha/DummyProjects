<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProfiledPieogramToScPieVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sc_pie_video', function (Blueprint $table) {
            $table->smallInteger('profiled_pieogram')->default(0)->after('pie_audio_id')->comment('0=>no, 1=>yes');
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
