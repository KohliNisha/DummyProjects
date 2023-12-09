<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AudienceReactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('audience_reactions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable(); 
            $table->string('url')->nullable(); 
            $table->Integer('type')->default('1')->comment('Audience Reactions type 1=>  Audience Reactions, 2=> Trending tags');
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
        Schema::dropIfExists('audience_reactions');
    }
}
