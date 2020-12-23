<?php

namespace Database\Seeders;

use App\BlockLayouts\TextImageListLayout;
use App\Models\BlockPage;
use App\Models\BlockType;
use App\Models\CTABlock;
use App\Models\FooterBlock;
use App\Models\HeroBlock;
use App\Models\Positioning;
use App\Models\SimpleTextImageBlock;
use App\Models\TestimonialBlock;
use App\Models\TextImageList;
use App\Models\TextImageListBlock;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StartPageBlockSeeder extends Seeder
{
    const HERO_BLOCK_ID = 10000;
    const TEXT_IMAGE_RIGHT_BLOCK_ID = 20000;
    const TEXT_IMAGE_LEFT_BLOCK_ID = 30000;
    const TESTIMONIAL_BLOCK = 40000;
    const CTA_BLOCK_ID = 60000;
    const TEXT_IMAGE_LIST_COLLAPSIBLE_BLOCK_ID = 80000;
    const TEXT_IMAGE_LIST_FEATURES_LIST_BLOCK_ID = 90000;
    const FOOTER_BLOCK_ID = 100000;


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
        $this->addOrUpdateHeroBlock(self::HERO_BLOCK_ID, ++$position);
        $this->addOrUpdateSimpleTextRightImageBlock(self::TEXT_IMAGE_RIGHT_BLOCK_ID, ++$position);
        $this->addOrUpdateSimpleTextLeftImageBlock(self::TEXT_IMAGE_LEFT_BLOCK_ID, ++$position);
        $this->addOrUpdateTextImageListBlockWithCollapsibleLayout(
            self::TEXT_IMAGE_LIST_COLLAPSIBLE_BLOCK_ID,
            ++$position
        );
        $this->addOrUpdateTextImageListBlockWithFeatureListLayout(
            self::TEXT_IMAGE_LIST_FEATURES_LIST_BLOCK_ID,
            ++$position
        );
        $this->addOrUpdateTestimonialBlock(self::TESTIMONIAL_BLOCK, ++$position);
        $this->addOrUpdateCTABlock(self::CTA_BLOCK_ID, ++$position);
        $this->addOrUpdateFooterBlock(self::FOOTER_BLOCK_ID, ++$position);
    }

    /**
     * @param int $blockId
     * @param int $position
     */
    private function addOrUpdateHeroBlock(int $blockId, int $position)
    {
        $blocktypeId = (BlockType::findByTag(HeroBlock::getBlockTypeTag()))->id;
        $dataSet = DatabaseSeeder::createDefaultBlockDataSet($blocktypeId, $blockId, true);

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
    private function addOrUpdateSimpleTextRightImageBlock(int $blockId, int $position)
    {
        $blocktypeId = (BlockType::findByTag(SimpleTextImageBlock::getBlockTypeTag()))->id;
        $blockId = 20000;
        $dataSet = DatabaseSeeder::createDefaultBlockDataSet($blocktypeId, $blockId, false);

        $dataSet[DatabaseSeeder::EXTENDED_BLOCK]['topic_image_border_color'] = '#3A4665';
        $dataSet[DatabaseSeeder::EXTENDED_BLOCK]['topic_image_horizontal_positioning_id'] = Positioning::findByCode(
            'right'
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

    /**
     * @param int $blockId
     * @param int $position
     */
    private function addOrUpdateSimpleTextLeftImageBlock(int $blockId, int $position)
    {
        $blocktypeId = (BlockType::findByTag(SimpleTextImageBlock::getBlockTypeTag()))->id;
        $blockId = 20000;
        $dataSet = DatabaseSeeder::createDefaultBlockDataSet($blocktypeId, $blockId, true);

        $dataSet[DatabaseSeeder::EXTENDED_BLOCK]['topic_image_border_color'] = '#3A4665';
        $dataSet[DatabaseSeeder::EXTENDED_BLOCK]['topic_image_horizontal_positioning_id'] = Positioning::findByCode(
            'left'
        )->id;

        $dataSet[DatabaseSeeder::TRANSLATION]['title_en'] = 'I am the title of another block '
            . 'with the image aligned to left';
        $dataSet[DatabaseSeeder::TRANSLATION]['content_en'] = 'I only consist of a few words. No button at the end '
            . ' this time. Euismod Risus Bibendum Tellus Euismod Risus Bibendum Tellus.';
        $dataSet[DatabaseSeeder::TRANSLATION]['button_label_en'] = null;
        $dataSet[DatabaseSeeder::TRANSLATION]['button_url_en'] = 'https://www.dutchnews.nl/';
        $dataSet[DatabaseSeeder::TRANSLATION]['topic_image_en'] = '/assets/sample_image_02.png';


        $dataSet[DatabaseSeeder::TRANSLATION]['title_nl'] = 'Ik ben de titel van een ander blok met'
            . ' de afbeelding links uitgelijnd';
        $dataSet[DatabaseSeeder::TRANSLATION]['content_nl'] = 'Ik bestaat maar uit een paar woorden,'
            . ' zoals lorem en ipsum.';
        $dataSet[DatabaseSeeder::TRANSLATION]['button_label_nl'] = null;
        $dataSet[DatabaseSeeder::TRANSLATION]['button_url_nl'] = null;
        $dataSet[DatabaseSeeder::TRANSLATION]['topic_image_nl'] = '/assets/sample_image_02.png';

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

    private function addOrUpdateCTABlock(int $blockId, int $position)
    {
        $blocktypeId = (BlockType::findByTag(CTABlock::getBlockTypeTag()))->id;
        $dataSet = DatabaseSeeder::createDefaultBlockDataSet($blocktypeId, $blockId, true);

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

    private function addOrUpdateTextImageListBlockWithCollapsibleLayout(int $blockId, int $position)
    {
        $blocktypeId = (BlockType::findByTag(TextImageListBlock::getBlockTypeTag()))->id;
        $dataSet = DatabaseSeeder::createDefaultBlockDataSet($blocktypeId, $blockId, false);

        $dataSet[DatabaseSeeder::BLOCK]['layout'] = TextImageListLayout::COLLAPSIBLE_ITEM_LIST_ID;

        DB::transaction(
            function () use ($dataSet, $position) {
                DatabaseSeeder::addOrUpdateBlock($dataSet[DatabaseSeeder::BLOCK]);
                $addImages = false;
                $addIcons = false;
                $textImageListDataSet = DatabaseSeeder::createTextImageListDataSet(
                    $dataSet[DatabaseSeeder::BLOCK]['id'],
                    5,
                    $addIcons,
                    $addImages
                );
                DatabaseSeeder::addOrUpdateTextImageList($textImageListDataSet);
                $dataSet[DatabaseSeeder::EXTENDED_BLOCK]['list_id'] = $dataSet[DatabaseSeeder::BLOCK]['id'];
                DatabaseSeeder::addOrUpdateExtendedBlock(
                    'text_image_list_blocks',
                    $dataSet[DatabaseSeeder::EXTENDED_BLOCK],
                    $dataSet[DatabaseSeeder::TRANSLATION],
                    TextImageListBlock::getSubjecttypeId()
                );

                DatabaseSeeder::assignBlockToPage(
                    $dataSet[DatabaseSeeder::BLOCK]['id'],
                    PagesSeeder::START_PAGE,
                    $position
                );
            }
        );
    }

    private function addOrUpdateTextImageListBlockWithFeatureListLayout(int $blockId, int $position)
    {
        $blocktypeId = (BlockType::findByTag(TextImageListBlock::getBlockTypeTag()))->id;
        $dataSet = DatabaseSeeder::createDefaultBlockDataSet($blocktypeId, $blockId, false);

        $dataSet[DatabaseSeeder::BLOCK]['layout'] = TextImageListLayout::COLLAPSIBLE_ITEM_LIST_ID;

        DB::transaction(
            function () use ($dataSet, $position) {
                DatabaseSeeder::addOrUpdateBlock($dataSet[DatabaseSeeder::BLOCK]);
                $addImages = false;
                $addIcons = true;
                $textImageListDataSet = DatabaseSeeder::createTextImageListDataSet(
                    $dataSet[DatabaseSeeder::BLOCK]['id'],
                    5,
                    $addIcons,
                    $addImages
                );
                DatabaseSeeder::addOrUpdateTextImageList($textImageListDataSet);
                $dataSet[DatabaseSeeder::EXTENDED_BLOCK]['list_id'] = $dataSet[DatabaseSeeder::BLOCK]['id'];
                DatabaseSeeder::addOrUpdateExtendedBlock(
                    'text_image_list_blocks',
                    $dataSet[DatabaseSeeder::EXTENDED_BLOCK],
                    $dataSet[DatabaseSeeder::TRANSLATION],
                    TextImageListBlock::getSubjecttypeId()
                );

                DatabaseSeeder::assignBlockToPage(
                    $dataSet[DatabaseSeeder::BLOCK]['id'],
                    PagesSeeder::START_PAGE,
                    $position
                );
            }
        );
    }

    private function addOrUpdateTestimonialBlock(int $blockId, int $position)
    {
        $faker = Factory::create('en_En');
        $blocktypeId = (BlockType::findByTag(TestimonialBlock::getBlockTypeTag()))->id;
        $dataSet = DatabaseSeeder::createDefaultBlockDataSet($blocktypeId, $blockId, false);
        $dataSet[DatabaseSeeder::BLOCK]['background_gradient'] = null;
        $dataSet[DatabaseSeeder::BLOCK]['button_background_color'] = null;//transparent
        $dataSet[DatabaseSeeder::BLOCK]['button_hover_background_color'] = null;
        $dataSet[DatabaseSeeder::BLOCK]['button_text_color'] = 'rgba(255, 100, 50, 1)';
        $dataSet[DatabaseSeeder::BLOCK]['button_hover_text_color'] = 'rgba(255, 100, 50, 1)';

        $dataSet[DatabaseSeeder::EXTENDED_BLOCK]['person_photo'] = '/images/assets/person_sample_image.png';

        $dataSet[DatabaseSeeder::TRANSLATION]['title_en'] = 'This is a Vision/Testimonial block';
        $dataSet[DatabaseSeeder::TRANSLATION]['content_en'] = '(Text EN) ' . collect($faker->words(25))->join(' ');
        $dataSet[DatabaseSeeder::TRANSLATION]['button_label_en'] = 'I am link to an external page';
        $dataSet[DatabaseSeeder::TRANSLATION]['button_url_en'] = 'https://www.dutchnews.nl/';
        $dataSet[DatabaseSeeder::TRANSLATION]['person_first_name_en'] = 'John';
        $dataSet[DatabaseSeeder::TRANSLATION]['person_last_name_en'] = 'Smith';
        $dataSet[DatabaseSeeder::TRANSLATION]['person_position_en'] = 'Executive director';

        $dataSet[DatabaseSeeder::TRANSLATION]['title_nl'] = 'Dit is een Vision / Testimonial-blok';
        $dataSet[DatabaseSeeder::TRANSLATION]['content_nl'] = '(Text NL) ' . collect($faker->words(25))->join(' ');
        $dataSet[DatabaseSeeder::TRANSLATION]['button_label_nl'] = 'Ik ben een link naar een externe pagina';
        $dataSet[DatabaseSeeder::TRANSLATION]['button_url_nl'] = 'https://www.telegraaf.nl/';
        $dataSet[DatabaseSeeder::TRANSLATION]['person_first_name_en'] = 'Jan';
        $dataSet[DatabaseSeeder::TRANSLATION]['person_last_name_en'] = 'de Vries';
        $dataSet[DatabaseSeeder::TRANSLATION]['person_position_en'] = 'Uitvoerend directeur';

        DB::transaction(
            function () use ($dataSet, $position) {
                DatabaseSeeder::addOrUpdateBlock($dataSet[DatabaseSeeder::BLOCK]);
                DatabaseSeeder::addOrUpdateExtendedBlock(
                    'testimonial_blocks',
                    $dataSet[DatabaseSeeder::EXTENDED_BLOCK],
                    $dataSet[DatabaseSeeder::TRANSLATION],
                    TestimonialBlock::getSubjecttypeId()
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
    private function addOrUpdateFooterBlock(int $blockId, int $position)
    {
        $blocktypeId = (BlockType::findByTag(FooterBlock::getBlockTypeTag()))->id;
        $dataSet = DatabaseSeeder::createDefaultBlockDataSet($blocktypeId, $blockId, true);

        $dataSet[DatabaseSeeder::BLOCK]['background_color'] = 'rgba(27, 34, 48, 0.6)';

        $dataSet[DatabaseSeeder::TRANSLATION]['site_logo_en'] = 'sample_logo.svg';
        $dataSet[DatabaseSeeder::TRANSLATION]['row_2_content_1_en'] = '<span><strong>Contact</strong><br>'
            . '<a href="https://www.eurosport.com">This is contact list</a></span>';
        $dataSet[DatabaseSeeder::TRANSLATION]['row_2_content_2_en'] = '<span><strong>Resources</strong><br>'
            . '<a href="https://www.eurosport.com">This is a resource link</a></span>';
        $dataSet[DatabaseSeeder::TRANSLATION]['row_2_content_3_en'] = '<span><strong>Press and media</strong><br>'
            . '<a href="https://www.eurosport.com">Press and media link</a></span>';
        $dataSet[DatabaseSeeder::TRANSLATION]['row_2_content_4_en'] = '<span><strong>Company name</strong><br>'
            . 'Address line 1<br>Address line 2<br>Address Line 3</span>';
        $dataSet[DatabaseSeeder::TRANSLATION]['row_3_content_1_copyright_en'] = '&copy; Sample copyright text';
        $dataSet[DatabaseSeeder::TRANSLATION]['row_3_content_2_imprint_en'] = '<a href="https://www.dutchnews.nl/">Imprint</a>';
        $dataSet[DatabaseSeeder::TRANSLATION]['row_3_content_3_terms_of_use_en'] = '<a href="https://www.dutchnews.nl/">Term of use</a>';
        $dataSet[DatabaseSeeder::TRANSLATION]['row_3_content_4_privacy_en'] = '<a href="https://www.dutchnews.nl/">Privacy policy</a>';

        $dataSet[DatabaseSeeder::TRANSLATION]['site_logo_nl'] = 'sample_logo.svg';
        $dataSet[DatabaseSeeder::TRANSLATION]['row_2_content_1_nl'] = '<span><strong>Contact</strong><br>'
            . '<a href="https://www.eurosport.com">This is contact list</a></span>';
        $dataSet[DatabaseSeeder::TRANSLATION]['row_2_content_2_nl'] = '<span><strong>Middelen</strong><br>'
            . '<a href="https://www.eurosport.com">This is a resource link</a></span>';
        $dataSet[DatabaseSeeder::TRANSLATION]['row_2_content_3_nl'] = '<span><strong>Pers en media</strong><br>'
            . '<a href="https://www.eurosport.com">Press and media link</a></span>';
        $dataSet[DatabaseSeeder::TRANSLATION]['row_2_content_4_nl'] = '<span><strong>Bedrijfsnaam</strong><br>'
            . 'Address line 1<br>Address line 2<br>Address Line 3</span>';
        $dataSet[DatabaseSeeder::TRANSLATION]['row_3_content_1_copyright_nl'] = '&copy; Voorbeeld copyrighttekst';
        $dataSet[DatabaseSeeder::TRANSLATION]['row_3_content_2_imprint_nl'] = '<a href="https://www.dutchnews.nl/">Colofon</a>';
        $dataSet[DatabaseSeeder::TRANSLATION]['row_3_content_3_terms_of_use_nl'] = '<a href="https://www.dutchnews.nl/">Gebruiksduur</a>';
        $dataSet[DatabaseSeeder::TRANSLATION]['row_3_content_4_privacy_nl'] = '<a href="https://www.dutchnews.nl/">Privacybeleid</a>';

        DB::transaction(
            function () use ($dataSet, $position) {
                DatabaseSeeder::addOrUpdateBlock($dataSet[DatabaseSeeder::BLOCK]);
                DatabaseSeeder::addOrUpdateExtendedBlock(
                    'footer_blocks',
                    $dataSet[DatabaseSeeder::EXTENDED_BLOCK],
                    $dataSet[DatabaseSeeder::TRANSLATION],
                    FooterBlock::getSubjecttypeId()
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
