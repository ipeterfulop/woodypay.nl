<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
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
                'name' => 'Admin',
                'email' => 'fulop.peter@datalytix.tech',
                'password' => bcrypt('a1b2c7'),
                'role_id' => Role::ADMIN_ID,
                'email_verified_at' => now(),
            ],
            [
                'name' => 'User',
                'email' => 'olah.tamas@datalytix.tech',
                'password' => bcrypt('a1b2c7'),
                'role_id' => Role::USER_ID,
                'email_verified_at' => null,
            ],
        ];
        foreach ($dataset as $row) {
            User::updateOrCreate(['email' => $row['email']], $row);
        }
    }
}
