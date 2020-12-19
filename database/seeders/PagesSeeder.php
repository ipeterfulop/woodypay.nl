<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataset = [
            ['id' => 1, 'name_en' => 'Main page', 'url' => '/', 'tag' => 'main'],
            ['id' => 2, 'name_en' => 'Privacy policy', 'url' => '/privacy', 'tag' => 'privacy'],
        ];

        foreach ($dataset as $row) {
            Page::updateOrCreateWithTranslations(['id' => $row['id']], $row);
        }
    }
}
