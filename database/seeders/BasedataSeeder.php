<?php

namespace Database\Seeders;

use App\Models\Spacing;
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
        $this->call(SubjecttypesSeeder::class);
        $this->call(BlockTypesSeeder::class);
        $this->call(PagesSeeder::class);
        $this->call(PositioningsSeeder::class);
        $this->call(SpacingsSeeder::class);
        $this->call(StartPageBlockSeeder::class);
    }
}
