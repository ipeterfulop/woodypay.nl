<?php

namespace Database\Seeders;

use App\Models\Block;
use App\Models\BlockType;
use App\Models\Positioning;
use App\Models\Spacing;
use App\Models\TextImageList;
use Illuminate\Database\Seeder;

class SubjecttypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataset = [
            ['id' => 1, 'name' => Block::class],
            ['id' => 2, 'name' => Page::class],
            ['id' => 3, 'name' => TextImageList::class],
            ['id' => 11, 'name' => TextImageItem::class],
            ['id' => 4, 'name' => BlockType::class],
            ['id' => 5, 'name' => Positioning::class],
            ['id' => 10, 'name' => Spacing::class],
        ];

        foreach ($dataset as $row) {
            $s = \DB::table('translationsubjecttypes')->where('id', '=', $row['id'])->first();
            if ($s == null) {
                \DB::table('translationsubjecttypes')->insert($row);
            } else {
                \DB::table('translationsubjecttypes')->where('id', '=', $row['id'])->update(
                    collect($row)->except(['id'])->all()
                );
            }
        }
    }
}
