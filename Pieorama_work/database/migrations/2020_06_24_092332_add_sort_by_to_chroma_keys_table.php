<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSortByToChromaKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chroma_keys', function (Blueprint $table) {
            $table->bigInteger('sort_by')->nullable()->after('chromak_keys_img')->comment('for sorting chroma keys');;
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
