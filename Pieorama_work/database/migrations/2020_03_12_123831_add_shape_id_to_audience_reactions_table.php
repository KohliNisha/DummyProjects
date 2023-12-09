<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShapeIdToAudienceReactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audience_reactions', function (Blueprint $table) {
            $table->Integer('shape_id')->default('1')->comment('shape_id 1=>  Landscape, 2=> portrait');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('audience_reactions', function (Blueprint $table) {
            //
        });
    }
}
