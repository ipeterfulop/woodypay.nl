<?php

namespace Database\Seeders;

use App\Models\AttributeValue;
use App\Models\Block;
use App\Models\BlockType;
use App\Models\Positioning;
use App\Models\Spacing;
use App\Models\TextImageCollectionList;
use App\Models\TextImageList;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use App\Models\Datatype;
use App\Models\Attributegroup;


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
            ['id' => 11, 'name' => TextImageCollectionList::class],
            ['id' => Datatype::SUBJECTTYPE_ID, 'name' => Datatype::class],
            ['id' => Attributegroup::SUBJECTTYPE_ID, 'name' => Attributegroup::class],
            ['id' => AttributeValue::SUBJECTTYPE_ID, 'name' => AttributeValue::class],

        ];

        foreach ($dataset as $row) {
            $s = DB::table('translationsubjecttypes')->where('id', '=', $row['id'])->first();
            if ($s == null) {
                DB::table('translationsubjecttypes')->insert($row);
            } else {
                DB::table('translationsubjecttypes')->where('id', '=', $row['id'])->update(
                    collect($row)->except(['id'])->all()
                );
            }
        }
    }
}
