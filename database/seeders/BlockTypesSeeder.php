<?php

namespace Database\Seeders;

use App\BlockLayouts\TextImageListCollectionBlockLayout;
use App\BlockLayouts\TextImageListLayout;
use App\Models\BlockType;
use App\Models\CTABlock;
use App\Models\FooterBlock;
use App\Models\HeroBlock;
use App\Models\SignupBlock;
use App\Models\SimpleTextImageBlock;
use App\Models\TestimonialBlock;
use App\Models\TextImageCollectionList;
use App\Models\TextImageList;
use App\Models\TextImageListBlock;
use App\Models\TextImageListCollectionBlock;
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
            ['id' => 1, 'name' => 'Hero block', 'tag' => HeroBlock::getBlockTypeTag()],
            ['id' => 2, 'name' => 'Text + image block', 'tag' => SimpleTextImageBlock::getBlockTypeTag()],
            ['id' => 3, 'name' => 'CTA block', 'tag' => CTABlock::getBlockTypeTag()],
            [
                'id'           => 4,
                'name'      => 'Text + image list block',
                'tag'          => TextImageListBlock::getBlockTypeTag(),
                'item_class'   => TextImageList::class,
                'layout_class' => TextImageListLayout::class,
            ],
            ['id' => 5, 'name' => 'Testimonial block', 'tag' => TestimonialBlock::getBlockTypeTag()],
            ['id' => 6, 'name' => 'Footer block', 'tag' => FooterBlock::getBlockTypeTag()],
            ['id'      => 7,
                'name' => 'Text + image list collection block',
                'tag'     => TextImageListCollectionBlock::getBlockTypeTag(),
                'item_class' => null,
                'layout_class' => TextImageListCollectionBlockLayout::class,
            ],
        ];

        foreach ($dataset as $row) {
            BlockType::updateOrCreateWithTranslations(['id' => $row['id']], $row);
        }
    }
}
