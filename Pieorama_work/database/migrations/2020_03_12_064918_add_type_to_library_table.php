<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTypeToLibraryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('library', function (Blueprint $table) {
            $table->Integer('type')->default('1')->comment('sound alert type 1=>  Splat sound, 2=> Other Sounds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('library', function (Blueprint $table) {
            //
        });
    }
}
