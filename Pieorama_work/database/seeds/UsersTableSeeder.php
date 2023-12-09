<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {    
         User::create([
            'first_name'=>'Developer',
            'last_name'=>'Backend',
            'user_role' => '1',
            'status' => '1',
            'email'=>'developer@yopmail.com',
            'password' => Hash::make('123456'),
            'auth_token'=>mt_rand(),
        ]);
    }
}
