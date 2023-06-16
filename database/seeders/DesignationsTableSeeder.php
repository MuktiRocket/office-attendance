<?php

namespace Database\Seeders;

use App\Models\Designation;
use Illuminate\Database\Seeder;

class DesignationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $designations = [
            [
                'designation' => 'Super Admin',
                'created_at' =>date("Y-m-d H:i:s"),
                'updated_at' =>date("Y-m-d H:i:s")
            ],
            [
                'designation' => 'Admin',
                'created_at' =>date("Y-m-d H:i:s"),
                'updated_at' =>date("Y-m-d H:i:s")
            ],
        ];
        Designation::insert($designations);
    }
}
