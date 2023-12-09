<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    { 
          Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('first_name',255)->nullable();
            $table->string('last_name',255)->nullable(); 
            $table->string('username',255)->nullable();         
            $table->string('email',255)->nullable();
            $table->string('password',255)->nullable();
            $table->string('profile_image')->nullable();  
            $table->date('date_of_birth')->nullable(); 
            $table->smallInteger('hide_dob')->default('0')->comment('0=>Unhide, 1=>Hide');   
            $table->string('gender',55)->nullable();
            $table->rememberToken()->nullable();
            $table->string('password_reset_token',255)->nullable();
            $table->string('device_token',500)->nullable();
            $table->smallInteger('device_type')->default(0)->comment('1 for android, 2 for ios');
            $table->string('access_token',1000)->nullable();
            $table->string('auth_token',755)->nullable();
            $table->integer('user_role')->default('2')->comment('1=>SuperAdmin');
            $table->string('facebook_id',255)->nullable()->comment('Facebook id');
            $table->string('google_id',255)->nullable()->comment('Google id');
            $table->string('twitter_id',255)->nullable()->comment('Twitter id');
            $table->string('linkedin_id',255)->nullable()->comment('Linkedin id');
            $table->string('instagram_id',255)->nullable()->comment('Instagram id');
            $table->string('phone_code',10)->nullable();
            $table->string('phone_number',15)->nullable();
            $table->string('otp',25)->nullable();           
            $table->integer('attempt')->default('0')->comment('incorrect password attempt count');
            $table->smallInteger('is_phone_verify')->default('0')->comment('phone 0 for unverified 1 for verified');
            $table->smallInteger('is_confirm')->default('0')->comment('Email confirmation 0=>not confirm, 1=> Confirmed');
            $table->integer('signupstep')->default(0)->comment('signup screen 1st complete');
            $table->smallInteger('status')->default('0')->comment('0=>Not activate, 1=> Activated');
            $table->dateTime('last_login')->nullable(); 
            $table->dateTime('last_time_used')->nullable();
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
        Schema::dropIfExists('users');
    }
}
