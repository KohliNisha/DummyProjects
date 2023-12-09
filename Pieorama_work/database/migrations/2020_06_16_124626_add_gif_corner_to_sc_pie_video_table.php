<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGifCornerToScPieVideoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sc_pie_video', function (Blueprint $table) {
             $table->smallInteger('gif_corner')->default(0)->after('profiled_pieogram')->comment('0=>no, 1=>yes');
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
