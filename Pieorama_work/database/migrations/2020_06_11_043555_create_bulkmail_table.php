<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBulkmailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bulkmail', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->unsigned()->default(0);
            $table->string("title");
            $table->string("subject");
            $table->text("body");
            $table->mediumText("replace_vars");
            $table->string("slug");
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
        Schema::dropIfExists('bulkmail');
    }
}
