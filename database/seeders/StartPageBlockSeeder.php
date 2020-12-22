<?php

namespace Database\Seeders;

use App\Models\BlockPage;
use App\Models\BlockType;
use App\Models\HeroBlock;
use App\Models\Positioning;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StartPageBlockSeeder extends Seeder
{


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
        $this->addOrCreateHeroBlock(++$position);
    }

    private function addOrCreateHeroBlock(int $position)
    {
        $blocktypeId = (BlockType::findByTag(HeroBlock::getBlockTypeTag()))->id;
        $id = 10000;
        $dataSet = DatabaseSeeder::getDefaultBlockDataSet($blocktypeId, $id, true);

        $dataSet[DatabaseSeeder::EXTENDED_BLOCK]['background_image'] = 'hero_image.svg';
        $dataSet[DatabaseSeeder::EXTENDED_BLOCK]['background_image_positioning_id'] = Positioning::findByCode(
            'left center'
        )->id;
        $dataSet[DatabaseSeeder::TRANSLATION]['title_en'] = 'This is the title of the introductory hero block';
        $dataSet[DatabaseSeeder::TRANSLATION]['content_en'] = 'This is just sample content, some lorem ipsum words, no more. '
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
                $blockFound = DB::table('blocks')
                                ->where('id', '=', $dataSet[DatabaseSeeder::BLOCK]['id'])
                                ->get()
                                ->count();
                if ($blockFound > 0) {
                    DB::table('blocks')
                      ->where('id', '=', $dataSet[DatabaseSeeder::BLOCK]['id'])
                      ->update($dataSet[DatabaseSeeder::BLOCK]);
                } else {
                    DB::table('blocks')->insert($dataSet[DatabaseSeeder::BLOCK]);
                }

                $extendedBlockFound = DB::table('hero_blocks')
                                        ->where('id', '=', $dataSet[DatabaseSeeder::BLOCK]['id'])
                                        ->get()
                                        ->count();
                if ($extendedBlockFound > 0) {
                    DB::table('hero_blocks')
                      ->where('id', '=', $dataSet[DatabaseSeeder::EXTENDED_BLOCK]['id'])
                      ->update($dataSet[DatabaseSeeder::EXTENDED_BLOCK]);
                } else {
                    DB::table('hero_blocks')->insert($dataSet[DatabaseSeeder::EXTENDED_BLOCK]);
                }

                DatabaseSeeder::addOrUpdateTranslations(
                    $dataSet[DatabaseSeeder::TRANSLATION],
                    $dataSet[DatabaseSeeder::BLOCK]['id'],
                    HeroBlock::getSubjecttypeId()
                );

                $blockpage = DB::table('block_page')->where('page_id', PagesSeeder::START_PAGE)
                               ->where('block_id', $dataSet[DatabaseSeeder::BLOCK]['id'])
                               ->get()
                               ->first();
                $blockpageDataSet = [
                    'page_id'    => PagesSeeder::START_PAGE,
                    'block_id'   => $dataSet[DatabaseSeeder::BLOCK]['id'],
                    'position'   => $position,
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ];

                if (!is_null($blockpage)) {
                    DB::table('block_page')
                      ->where('id', $blockpage->id)
                      ->update($blockpageDataSet);
                } else {
                    DB::table('block_page')->insert($blockpageDataSet);
                }
            }
        );
    }
}
