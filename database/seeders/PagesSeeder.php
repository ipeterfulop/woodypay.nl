<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PagesSeeder extends Seeder
{
    const START_PAGE = 1;
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataset = [
            ['id' => self::START_PAGE, 'name' => 'Main page', 'url' => '/', 'url_nl' => '/', 'tag' => 'main'],
            ['id' => 2, 'name' => 'Privacy policy', 'url' => '/privacy', 'url_nl' => '/privacybeleid', 'tag' => 'privacy'],
        ];

        foreach ($dataset as $row) {
            Page::updateOrCreateWithTranslations(['id' => $row['id']], $row);
        }
    }
}
