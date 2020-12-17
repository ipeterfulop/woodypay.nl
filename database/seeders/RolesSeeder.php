<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataset = [
            [
                'id' => Role::ADMIN_ID,
                'name' => 'Administrator',
                'slug' => 'admin',
                'is_admin' => 1,
            ],
            [
                'id' => Role::USER_ID,
                'name' => 'User',
                'slug' => 'user',
                'is_admin' => 0,
            ],
        ];

        foreach($dataset as $row) {
            Role::updateOrCreate(['id' => $row['id']], $row);
        }
    }
}
