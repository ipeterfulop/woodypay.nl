<?php

namespace Database\Seeders;

use App\Models\BlockType;
use App\Models\HeroBlock;
use App\Models\SimpleTextImageBlock;
use App\Models\TextImageListBlock;
use Illuminate\Database\Seeder;

class BlockTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataset = [
            ['id' => 1, 'name_en' => 'Hero block', 'tag' => HeroBlock::getBlockTypeTag()],
            ['id' => 2, 'name_en' => 'Text + image block', 'tag' => SimpleTextImageBlock::getBlockTypeTag()],
            ['id' => 3, 'name_en' => 'Text + image list block', 'tag' => TextImageListBlock::getBlockTypeTag()],
        ];

        foreach ($dataset as $row) {
            BlockType::updateOrCreateWithTranslations(['id' => $row['id']], $row);
        }
    }
}