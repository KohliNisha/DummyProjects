<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PieFlavor extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pie_flavor', function (Blueprint $table) {
            $table->increments('id');
            $table->string('p_name')->nullable(); 
            $table->longText('p_img')->nullable(); 
            $table->Integer('type')->default('1')->comment('pie flavor type 1=>  Pie Flavor, 2=> Chroma Keys');
            $table->smallInteger('status')->default('0')->comment('Page activate status 0=>  Inactivate, 1=> Active');
            $table->smallInteger('is_deleted')->default('0');  
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
        Schema::dropIfExists('pie_flavor');
    }
}
