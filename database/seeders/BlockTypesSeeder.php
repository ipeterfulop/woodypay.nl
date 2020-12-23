<?php

namespace Database\Seeders;

use App\BlockLayouts\TextImageListLayout;
use App\Models\BlockType;
use App\Models\CTABlock;
use App\Models\HeroBlock;
use App\Models\SimpleTextImageBlock;
use App\Models\TestimonialBlock;
use App\Models\TextImageList;
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
            ['id' => 3, 'name_en' => 'CTA block', 'tag' => CTABlock::getBlockTypeTag()],
            [
                'id'         => 4,
                'name_en'    => 'Text + image list block',
                'tag'        => TextImageListBlock::getBlockTypeTag(),
                'item_class' => TextImageList::class,
                'layout_class' => TextImageListLayout::class,
            ],
            ['id' => 8, 'name_en' => 'Testimonial block', 'tag' => TestimonialBlock::getBlockTypeTag()],
        ];

        foreach ($dataset as $row) {
            BlockType::updateOrCreateWithTranslations(['id' => $row['id']], $row);
        }
    }
}
