<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BasedataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(LocalesSeeder::class);
        $this->call(TranslationsSeeder::class);
    }
}
