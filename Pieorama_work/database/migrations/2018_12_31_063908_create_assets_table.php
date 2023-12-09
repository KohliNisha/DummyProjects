<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('org_name',255)->nullable();
            $table->string('file_name',255)->nullable();
            $table->string('path',255)->nullable();
            $table->string('mime',255)->nullable();
            $table->string('ext',255)->nullable();
            $table->string('module',255)->nullable();
            $table->integer('user_id')->default(0);
            $table->integer('document_id')->default(0);
            $table->integer('is_temp')->default(0);
            $table->string('is_imported',2)->nullable();
            $table->longText('import_url')->nullable();
            $table->longText('import_unique_key')->nullable();
            $table->longText('cloudinary_details')->nullable();
            $table->string('bytes',255)->nullable();
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
        Schema::dropIfExists('assets');
    }
}
