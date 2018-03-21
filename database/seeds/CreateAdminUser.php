<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CreateAdminUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Junior Silva',
            'email' => 'admin@admin.com',
            'password' => bcrypt('123456'),
            'created_at' => date('Y-m-d H:i:m'),
            'updated_at' => date('Y-m-d H:i:m'),
            'remember_token' => str_random(10)
        ]);
    }
}
