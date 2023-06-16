<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            'first_name' => 'User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('Admin@123'),
            'created_at' =>date("Y-m-d H:i:s"),
            'updated_at' =>date("Y-m-d H:i:s"),
            'last_name' => 'Admin',
            'phone_number' => '8420926469',
        ]);
    }
}
