<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnsubscribeUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unsubscribe_users', function (Blueprint $table) {
            $table->increments('id');
            
            $table->string('email',255)->nullable();
            
            $table->smallInteger('newsletter')->default(0)->comment('0=>unsubscribe, 1=>subscribe');
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
        Schema::dropIfExists('unsubscribe_users');
    }
}
