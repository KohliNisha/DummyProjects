<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SoundAlert extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sound_alert', function (Blueprint $table) {
            $table->increments('s_id');
            $table->string('s_name')->nullable(); 
            $table->string('s_url')->nullable(); 
            $table->Integer('type')->default('1')->comment('sound alert type 1=>  Splat sound, 2=> Other Sounds');
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
         Schema::dropIfExists('sound_alert');
    }
}
