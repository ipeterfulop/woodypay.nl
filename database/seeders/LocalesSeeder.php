<?php

namespace Database\Seeders;

use App\Models\Locale;
use Illuminate\Database\Seeder;

class LocalesSeeder extends Seeder
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
                'id' => 'en',
                'name' => 'English',
                'is_main' => 1,
                'decimal_separator' => '.',
            ],
            [
                'id' => 'nl',
                'name' => 'Dutch',
                'is_main' => 1,
                'decimal_separator' => '.',
            ],
        ];

        foreach ($dataset as $row) {
            Locale::updateOrCreate(['id' => $row['id']], $row);
        }
    }
}
