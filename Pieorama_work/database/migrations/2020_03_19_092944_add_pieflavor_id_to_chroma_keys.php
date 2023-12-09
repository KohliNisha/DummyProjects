<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPieflavorIdToChromaKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('chroma_keys', function (Blueprint $table) {
            $table->bigInteger('pieflavor_id')->after('chroma_key_id')->default(1);
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
