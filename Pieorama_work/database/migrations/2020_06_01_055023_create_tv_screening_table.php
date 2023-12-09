<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTvScreeningTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tv_screening', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->unsigned()->default(0);
            $table->foreign('user_id')->references('id')->on('users');
            
            $table->string('title',1000)->nullable();
            
            $table->string('file_name',1000)->nullable();
            
            $table->bigInteger('updated_by')->default(0);
            $table->smallInteger('status')->default(0)->comment('0=>Active, 1=>Inactive');
            $table->smallInteger('is_delete')->default(0)->comment('0=>UnDelete, 1=>Delete');
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
        Schema::dropIfExists('tv_screening');
    }
}
