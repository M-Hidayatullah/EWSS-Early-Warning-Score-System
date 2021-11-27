<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
               'nama' => 'admin',
               'email'=> 'admin@gmail.com',
               'phone'=> '087856780210',
               'country' => 'indonesia',
               'city' => 'mataram',
               'email_verified_at' => now(),
               'password' =>bcrypt('admin123'),
               'remember_token' => Str::random(10),
               'created_at' => date("Y-m-d H:i:s"),
               'updated_at' => date("Y-m-d H:i:s")
            ]
        ]);
    }
}
