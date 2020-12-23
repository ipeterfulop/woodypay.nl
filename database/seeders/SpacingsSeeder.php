<?php

namespace Database\Seeders;

use App\Models\Spacing;
use Illuminate\Database\Seeder;

class SpacingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataSet = [
            ['name_en' => 'spacing-2', 'size_in_rems' => 0.5],
            ['name_en' => 'spacing-2.5', 'size_in_rems' => 0.625],
            ['name_en' => 'spacing-3', 'size_in_rems' => 0.75],
            ['name_en' => 'spacing-3.5', 'size_in_rems' => 0.875],
            ['name_en' => 'spacing-4', 'size_in_rems' => 1],
            ['name_en' => 'spacing-5', 'size_in_rems' => 1.25],
            ['name_en' => 'spacing-6', 'size_in_rems' => 1.5],
            ['name_en' => 'spacing-7', 'size_in_rems' => 1.75],
            ['name_en' => 'spacing-8', 'size_in_rems' => 2],
            ['name_en' => 'spacing-9', 'size_in_rems' => 2.25],
            ['name_en' => 'spacing-10', 'size_in_rems' => 2.5],
            ['name_en' => 'spacing-11', 'size_in_rems' => 2.75],
            ['name_en' => 'spacing-12', 'size_in_rems' => 3],
            ['name_en' => 'spacing-14', 'size_in_rems' => 3.5],
            ['name_en' => 'spacing-16', 'size_in_rems' => 4],
            ['name_en' => 'spacing-20', 'size_in_rems' => 5],
            ['name_en' => 'spacing-24', 'size_in_rems' => 6],
            ['name_en' => 'spacing-28', 'size_in_rems' => 7],
            ['name_en' => 'spacing-32', 'size_in_rems' => 8],
            ['name_en' => 'spacing-36', 'size_in_rems' => 9],
            ['name_en' => 'spacing-40', 'size_in_rems' => 10],
            ['name_en' => 'spacing-44', 'size_in_rems' => 11],
        ];
        $index = 1;
        foreach ($dataSet as &$item) {
            $item['name_nl'] = str_replace('spacing', 'spatiëring', $item['name_en']);
            $item['id'] = $index++;
            Spacing::updateOrCreateWithTranslations(['id' => $item['id']], $item);
        }
    }
}
