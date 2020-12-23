<?php

namespace Database\Seeders;

use App\Models\BlockPage;
use App\Models\BlockType;
use App\Models\CTABlock;
use App\Models\HeroBlock;
use App\Models\Positioning;
use App\Models\SimpleTextImageBlock;
use App\Models\TextImageListBlock;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StartPageBlockSeeder extends Seeder
{
    const HERO_BLOCK_ID = 10000;
    const TEXT_IMAGE_BLOCK_ID = 20000;
    const TEXT_IMAGE_LIST_BLOCK_ID = 30000;
    const CTA_BLOCK_ID = 70000;


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addOrUpdateBlocks();
    }

    private function addOrUpdateBlocks()
    {
        $position = 0;
        $this->addOrCreateHeroBlock(self::HERO_BLOCK_ID, ++$position);
        $this->addOrCreateSimpleTextImageBlock(self::TEXT_IMAGE_BLOCK_ID, ++$position);
        $this->addOrCreateTextImageListBlock(self::TEXT_IMAGE_LIST_BLOCK_ID, ++$position);
        $this->addOrCreateCTABlock(self::CTA_BLOCK_ID, ++$position);
    }

    /**
     * @param int $blockId
     * @param int $position
     */
    private function addOrCreateHeroBlock(int $blockId, int $position)
    {
        $blocktypeId = (BlockType::findByTag(HeroBlock::getBlockTypeTag()))->id;
        $dataSet = DatabaseSeeder::getDefaultBlockDataSet($blocktypeId, $blockId, true);

        $dataSet[DatabaseSeeder::BLOCK]['background_gradient'] = 'linear-gradient(to bottom, '
            . 'rgba(58, 70, 101, 0.4), rgba(27, 34, 48, 0.4))';
        $dataSet[DatabaseSeeder::EXTENDED_BLOCK]['background_image'] = '/assets/hero_image.svg';
        $dataSet[DatabaseSeeder::EXTENDED_BLOCK]['background_image_positioning_id'] = Positioning::findByCode(
            'left center'
        )->id;
        $dataSet[DatabaseSeeder::TRANSLATION]['title_en'] = 'This is the title of the introductory hero block';
        $dataSet[DatabaseSeeder::TRANSLATION]['content_en'] = 'This is just sample content, '
            . 'some lorem ipsum words, no more. '
            . 'Sollicitudin Tellus Inceptos Etiam, Sollicitudin Tellus Inceptos Etiam.';
        $dataSet[DatabaseSeeder::TRANSLATION]['button_label_en'] = 'Press me, I am a button';
        $dataSet[DatabaseSeeder::TRANSLATION]['button_url_en'] = 'https://www.dutchnews.nl/';

        $dataSet[DatabaseSeeder::TRANSLATION]['title_nl'] = 'Dit is de titel van het inleidende gedeelte';
        $dataSet[DatabaseSeeder::TRANSLATION]['content_nl'] = 'Dit is slechts voorbeeldinhoud, enkele woorden van lorem'
            . ' ipsum, meer niet. Sollicitudin Tellus Inceptos Etiam, Sollicitudin Tellus Inceptos Etiam.';
        $dataSet[DatabaseSeeder::TRANSLATION]['button_label_nl'] = 'Druk op mij, ik ben een knop.';
        $dataSet[DatabaseSeeder::TRANSLATION]['button_url_nl'] = 'https://www.telegraaf.nl/';

        DB::transaction(
            function () use ($dataSet, $position) {
                DatabaseSeeder::addOrUpdateBlock($dataSet[DatabaseSeeder::BLOCK]);
                DatabaseSeeder::addOrUpdateExtendedBlock(
                    'hero_blocks',
                    $dataSet[DatabaseSeeder::EXTENDED_BLOCK],
                    $dataSet[DatabaseSeeder::TRANSLATION],
                    HeroBlock::getSubjecttypeId()
                );
                DatabaseSeeder::assignBlockToPage(
                    $dataSet[DatabaseSeeder::BLOCK]['id'],
                    PagesSeeder::START_PAGE,
                    $position
                );
            }
        );
    }

    /**
     * @param int $blockId
     * @param int $position
     */
    private function addOrCreateSimpleTextImageBlock(int $blockId, int $position)
    {
        $blocktypeId = (BlockType::findByTag(SimpleTextImageBlock::getBlockTypeTag()))->id;
        $blockId = 20000;
        $dataSet = DatabaseSeeder::getDefaultBlockDataSet($blocktypeId, $blockId, false);

        $dataSet[DatabaseSeeder::EXTENDED_BLOCK]['topic_image_border_color'] = '#3A4665';
        $dataSet[DatabaseSeeder::EXTENDED_BLOCK]['topic_image_horizontal_positioning_id'] = Positioning::findByCode(
            'right center'
        )->id;

        $dataSet[DatabaseSeeder::TRANSLATION]['title_en'] = 'I am the title of a block with image and formatted text';
        $dataSet[DatabaseSeeder::TRANSLATION]['content_en'] = 'I only consist of a few words like lorem and ipsum.'
            . 'Sollicitudin Tellus Inceptos Etiam, Sollicitudin Tellus Inceptos Etiam.';
        $dataSet[DatabaseSeeder::TRANSLATION]['button_label_en'] = 'Click me, I am a button';
        $dataSet[DatabaseSeeder::TRANSLATION]['button_url_en'] = 'https://www.dutchnews.nl/';
        $dataSet[DatabaseSeeder::TRANSLATION]['topic_image_en'] = '/assets/topic_image.png';


        $dataSet[DatabaseSeeder::TRANSLATION]['title_nl'] = 'Ik ben de titel van een blok met'
            . ' afbeelding en opgemaakte tekst';
        $dataSet[DatabaseSeeder::TRANSLATION]['content_nl'] = 'Ik bestaat maar uit een paar woorden,'
            . ' zoals lorem en ipsum.';
        $dataSet[DatabaseSeeder::TRANSLATION]['button_label_nl'] = 'Klik op mij, ik ben een knop';
        $dataSet[DatabaseSeeder::TRANSLATION]['button_url_nl'] = 'https://www.telegraaf.nl/';
        $dataSet[DatabaseSeeder::TRANSLATION]['topic_image_nl'] = '/assets/topic_image.png';

        DB::transaction(
            function () use ($dataSet, $position) {
                DatabaseSeeder::addOrUpdateBlock($dataSet[DatabaseSeeder::BLOCK]);
                DatabaseSeeder::addOrUpdateExtendedBlock(
                    'simple_text_image_blocks',
                    $dataSet[DatabaseSeeder::EXTENDED_BLOCK],
                    $dataSet[DatabaseSeeder::TRANSLATION],
                    SimpleTextImageBlock::getSubjecttypeId()
                );
                DatabaseSeeder::assignBlockToPage(
                    $dataSet[DatabaseSeeder::BLOCK]['id'],
                    PagesSeeder::START_PAGE,
                    $position
                );
            }
        );
    }

    private function addOrCreateCTABlock(int $blockId, int $position)
    {
        $blocktypeId = (BlockType::findByTag(CTABlock::getBlockTypeTag()))->id;
        $dataSet = DatabaseSeeder::getDefaultBlockDataSet($blocktypeId, $blockId, true);

        $dataSet[DatabaseSeeder::BLOCK]['background_color'] = null;

        $dataSet[DatabaseSeeder::TRANSLATION]['title_en'] = 'I am the title of this call-to-action (CTA) block';
        $dataSet[DatabaseSeeder::TRANSLATION]['button_label_en'] = 'Press the CTA button';
        $dataSet[DatabaseSeeder::TRANSLATION]['button_url_en'] = 'https://www.dutchnews.nl/';

        $dataSet[DatabaseSeeder::TRANSLATION]['title_nl'] = 'Ik ben de titel van dit call-to-action (CTA) -blok';
        $dataSet[DatabaseSeeder::TRANSLATION]['button_label_nl'] = 'Druk op de CTA-knop.';
        $dataSet[DatabaseSeeder::TRANSLATION]['button_url_nl'] = 'https://www.telegraaf.nl/';

        DB::transaction(
            function () use ($dataSet, $position) {
                DatabaseSeeder::addOrUpdateBlock($dataSet[DatabaseSeeder::BLOCK]);
                DatabaseSeeder::addOrUpdateExtendedBlock(
                    'cta_blocks',
                    $dataSet[DatabaseSeeder::EXTENDED_BLOCK],
                    $dataSet[DatabaseSeeder::TRANSLATION],
                    CTABlock::getSubjecttypeId()
                );
                DatabaseSeeder::assignBlockToPage(
                    $dataSet[DatabaseSeeder::BLOCK]['id'],
                    PagesSeeder::START_PAGE,
                    $position
                );
            }
        );
    }

    private function addOrCreateTextImageListBlock(int $blockId, int $position)
    {
        $blocktypeId = (BlockType::findByTag(TextImageListBlock::getBlockTypeTag()))->id;
        $dataSet = DatabaseSeeder::getDefaultBlockDataSet($blocktypeId, $blockId, false);

        $dataSet[DatabaseSeeder::BLOCK]['background_color'] = null;

        DB::transaction(
            function () use ($dataSet, $position) {
                DatabaseSeeder::addOrUpdateBlock($dataSet[DatabaseSeeder::BLOCK]);
                DatabaseSeeder::addOrUpdateExtendedBlock(
                    'cta_blocks',
                    $dataSet[DatabaseSeeder::EXTENDED_BLOCK],
                    $dataSet[DatabaseSeeder::TRANSLATION],
                    CTABlock::getSubjecttypeId()
                );
                DatabaseSeeder::assignBlockToPage(
                    $dataSet[DatabaseSeeder::BLOCK]['id'],
                    PagesSeeder::START_PAGE,
                    $position
                );
            }
        );
    }


}
