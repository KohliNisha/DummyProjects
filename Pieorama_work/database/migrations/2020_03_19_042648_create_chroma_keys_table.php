<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChromaKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chroma_keys', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',255)->nullable();
            $table->string('chromak_keys_img',555)->nullable();
            $table->bigInteger('chroma_key_id')->default(1)->comment('1=>Landscape, 2=>Portrait');
            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->smallInteger('is_deleted')->default(0)->comment('0=>Notdeleted, 1=>Deleted');
            $table->dateTime('deleted_at')->nullable();
            $table->smallInteger('status')->default('0')->comment('0=>Not activate, 1=> Activated');
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
        Schema::dropIfExists('chroma_keys');
    }
}