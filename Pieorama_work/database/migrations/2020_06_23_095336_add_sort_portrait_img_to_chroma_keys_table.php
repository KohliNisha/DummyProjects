<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSortPortraitImgToChromaKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chroma_keys', function (Blueprint $table) {
             $table->bigInteger('sort_portrait_img')->nullable()->after('chromak_keys_img');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('chroma_keys', function (Blueprint $table) {
            //
        });
    }
}
