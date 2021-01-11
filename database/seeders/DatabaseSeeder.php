<?php

namespace Database\Seeders;

use App\FontAwesomeIconGenerator;
use App\Models\HeroBlock;
use App\Models\Locale;
use App\Models\TextImageCollectionList;
use App\Models\TextImageItem;
use App\Models\TextImageList;
use App\Models\Translation;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    const BLOCK = 'block';
    const EXTENDED_BLOCK = 'extendedBlock';
    const TRANSLATION = 'Translation';
    const TEXT_IMAGE_LIST = 'TextImageList';
    const TEXT_IMAGE_LIST_ITEM = 'TextImageListItem';
    const CORE_FIELDS = 'BasicFields';

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(BasedataSeeder::class);
        $this->call(AdminMenuSeeder::class);
    }

    /**
     * @param int $blocktypeId
     * @param int|null $id
     * @param bool $isDarkTheme
     * @return array[]
     */
    public static function createDefaultBlockDataSet(int $blocktypeId, int $id = null, bool $isDarkTheme = false): array
    {
        $dataSet = [
            self::BLOCK          => [
                'id'                                   => $id,
                'blocktype_id'                         => $blocktypeId,
                'layout'                               => null,
                'should_open_button_url_in_new_window' => 1,
                'created_at'                           => \Carbon\Carbon::now(),
                'updated_at'                           => \Carbon\Carbon::now(),
            ],
            self::EXTENDED_BLOCK => [
                'id'         => $id,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            self::TRANSLATION    => [

            ],
        ];

        if ($isDarkTheme) {
            $dataSet[self::BLOCK]['text_color'] = 'rgba(232, 226, 225, 1)';
            $dataSet[self::BLOCK]['background_color'] = 'rgba(27, 34, 48, 1)';
            $dataSet[self::BLOCK]['background_gradient'] = null;
            $dataSet[self::BLOCK]['button_background_color'] = 'rgba(232, 226, 225, 1)';
            $dataSet[self::BLOCK]['button_text_color'] = 'rgba(27, 34, 48, 1)';
            $dataSet[self::BLOCK]['button_hover_background_color'] = 'rgba(58, 70, 101, 1)';
            $dataSet[self::BLOCK]['button_hover_text_color'] = 'rgba(233, 234, 234, 1)';
        } else {
            $dataSet[self::BLOCK]['text_color'] = '#1B2230';
            $dataSet[self::BLOCK]['background_color'] = '#E2E8E1';
            $dataSet[self::BLOCK]['background_gradient'] = null;
            $dataSet[self::BLOCK]['button_background_color'] = '#1B2230';
            $dataSet[self::BLOCK]['button_text_color'] = '#FFFFFF';
            $dataSet[self::BLOCK]['button_hover_background_color'] = '#3A4665';
            $dataSet[self::BLOCK]['button_hover_text_color'] = '#FFFFFF';
        }

        return $dataSet;
    }

    public static function addOrUpdateTranslations(array $dataSet, int $subjectId, int $subjecttypeId)
    {
        $fields = array_keys($dataSet);
        $index = 0;
        foreach ($fields as $field) {
            $locale = (strrpos($field, '_') !== false)
                ? substr($field, strrpos($field, '_') + 1)
                : null;
            $translatedField = substr($field, 0, strrpos($field, '_'));
            if (!is_null(Locale::find($locale))) {
                if (!is_null($dataSet[$field])) {
                    $translationDataSet = [
                        'id'             => null,
                        'subjecttype_id' => $subjecttypeId,
                        'subject_id'     => $subjectId,
                        'locale_id'      => $locale,
                        'translation'    => $dataSet[$field],
                        'key'            => $subjectId . '-' . $subjecttypeId . '-' . $translatedField,
                        'field'          => $translatedField,
                        'created_at'     => Carbon::now(),
                        'updated_at'     => Carbon::now(),
                    ];

                    $translation = Translation::where('subject_id', $subjectId)
                                              ->where('subjecttype_id', $subjecttypeId)
                                              ->where('locale_id', $locale)
                                              ->where('field', $translatedField)
                                              ->get()
                                              ->first();

                    if (!is_null($translation)) {
                        $translationDataSet['id'] = $translation->id;
                        DB::table('translations')->where('id', $translation->id)->update($translationDataSet);
                    } else {
                        $translationDataSet['id'] = $subjectId + (++$index);
                        DB::table('translations')->insert($translationDataSet);
                    }
                }
            }
        }
    }

    public static function addOrUpdateBlock(array $block)
    {
        $blockFound = DB::table('blocks')
                        ->where('id', '=', $block['id'])
                        ->get()
                        ->count();
        if ($blockFound > 0) {
            DB::table('blocks')
              ->where('id', '=', $block['id'])
              ->update($block);
        } else {
            DB::table('blocks')->insert($block);
        }
    }

    public static function addOrUpdateExtendedBlock(
        $extendedBlockTable,
        $extendedBlockDataSet,
        $translationDataSet,
        $subjecttypeId
    ) {
        $extendedBlockFound = DB::table($extendedBlockTable)
                                ->where('id', '=', $extendedBlockDataSet['id'])
                                ->get()
                                ->count();
        if ($extendedBlockFound > 0) {
            DB::table($extendedBlockTable)
              ->where('id', '=', $extendedBlockDataSet['id'])
              ->update($extendedBlockDataSet);
        } else {
            DB::table($extendedBlockTable)->insert($extendedBlockDataSet);
        }

        self::addOrUpdateTranslations(
            $translationDataSet,
            $extendedBlockDataSet['id'],
            $subjecttypeId
        );
    }

    public static function assignBlockToPage($blockId, $pageId, $position)
    {
        $blockpage = DB::table('block_page')->where('page_id', $pageId)
                       ->where('block_id', $blockId)
                       ->get()
                       ->first();
        $blockpageDataSet = [
            'page_id'    => $pageId,
            'block_id'   => $blockId,
            'position'   => $position,
            'visibility' => 2,
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

    /**
     * @param $textImageListId
     * @param int $numberOfItems
     * @param false $addIconToItems
     * @param false $addImageToItems
     * @return array
     */
    public static function createTextImageListDataSet(
        $textImageListId,
        $numberOfItems = 6,
        $addIconToItems = false,
        $addImageToItems = false,
        $addTitleToTheList = true
    ): array {
        $faker = Factory::create('en_En');
        $numberOfWordsToGenerate = 25;
        $dataSet = [];

        $dataSet[self::TEXT_IMAGE_LIST][self::CORE_FIELDS] = [
            'id' => $textImageListId,
        ];


        $dataSet[self::TEXT_IMAGE_LIST][self::TRANSLATION] = [
            'topic_image_en' => 'sample_image_02.png',
            'topic_image_nl' => 'sample_image_02.png',
        ];

        if ($addTitleToTheList) {
            $dataSet[self::TEXT_IMAGE_LIST][self::CORE_FIELDS]['title'] = '(List title EN)I am a block with '
                . 'a text list and a topic image';
            $dataSet[self::TEXT_IMAGE_LIST][self::CORE_FIELDS]['content'] = '(List content EN) '
                . collect($faker->words($numberOfWordsToGenerate))->join(' ');
            $dataSet[self::TEXT_IMAGE_LIST][self::TRANSLATION]['title_en'] = $dataSet[self::TEXT_IMAGE_LIST][self::CORE_FIELDS]['title'];
            $dataSet[self::TEXT_IMAGE_LIST][self::TRANSLATION]['content_en'] = $dataSet[self::TEXT_IMAGE_LIST][self::CORE_FIELDS]['content'];
            $dataSet[self::TEXT_IMAGE_LIST][self::TRANSLATION]['title_nl'] = ' (List title NL) Ik ben een blok'
                . ' met een tekstlijst en een onderwerpafbeelding';
            $dataSet[self::TEXT_IMAGE_LIST][self::TRANSLATION]['content_nl'] = '(List content NL) '
                . collect($faker->words($numberOfWordsToGenerate))->join(' ');
        }

        $dataSet[self::TEXT_IMAGE_LIST][self::TEXT_IMAGE_LIST_ITEM] = [];
        for ($i = 1; $i <= $numberOfItems; $i++) {
            $itemDataSet = [
                self::CORE_FIELDS => [
                    'id'                 => 100 * ($textImageListId + $i),
                    'text_image_list_id' => $textImageListId,
                    'position'           => $i,
                    'fa_icon_classes'    => null,
                ],
                self::TRANSLATION => [
                    'title_en'   => 'I am a list item (' . str_pad($i, 2, '0', STR_PAD_LEFT) . ')',
                    'content_en' => '(Text EN) ' . collect($faker->words($numberOfWordsToGenerate + 10))->join(' '),
                    'url_en'     => 'https://www.apple.com/en/',

                    'title_nl'   => 'Ik ben een lijstitem (' . str_pad($i, 2, '0') . ')',
                    'content_nl' => '(Text EN) ' . collect($faker->words(9))->join(' '),
                    'url_nl'     => 'https://www.apple.com/nl/',
                ],
            ];

            if ($addIconToItems) {
                $iconClass = FontAwesomeIconGenerator::getRandomIconClass();
                $itemDataSet[self::CORE_FIELDS]['fa_icon_classes'] = $iconClass;
                $itemDataSet[self::TRANSLATION]['fa_icon_classes_en'] = $iconClass;
                $itemDataSet[self::TRANSLATION]['fa_icon_classes_nl'] = $iconClass;
            }

            $dataSet[self::TEXT_IMAGE_LIST][self::TEXT_IMAGE_LIST_ITEM][] = $itemDataSet;
        }

        {
            return $dataSet;
        }
    }

    public static function addOrUpdateTextImageList($dataSet)
    {
        //adding basic data
        $textImageListDataSet = [
            'id'         => $dataSet[self::TEXT_IMAGE_LIST][self::CORE_FIELDS]['id'],
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
        $textImageListFound = (TextImageList::where('id', '=', $textImageListDataSet['id'])->get()->count() > 0);
        if ($textImageListFound) {
            DB::table('text_image_lists')
              ->where('id', '=', $textImageListDataSet['id'])
              ->update($textImageListDataSet);
        } else {
            DB::table('text_image_lists')
              ->insert($textImageListDataSet);
        }

        //adding translations
        self::addOrUpdateTranslations(
            $dataSet[self::TEXT_IMAGE_LIST][self::TRANSLATION],
            $textImageListDataSet['id'],
            TextImageList::getSubjecttypeId()
        );

        //adding items
        foreach ($dataSet[self::TEXT_IMAGE_LIST][self::TEXT_IMAGE_LIST_ITEM] as $textImageItem) {
            $textImageItemDataSet = [
                'id'                 => $textImageItem[self::CORE_FIELDS]['id'],
                'text_image_list_id' => $textImageItem[self::CORE_FIELDS]['text_image_list_id'],
                'position'           => $textImageItem[self::CORE_FIELDS]['position'],
                'fa_icon_classes'    => $textImageItem[self::CORE_FIELDS]['fa_icon_classes'],
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now(),
            ];
            $textImageItemFound = (TextImageItem::where('id', '=', $textImageItemDataSet['id'])->get()->count() > 0);
            if ($textImageItemFound) {
                DB::table('text_image_items')
                  ->where('id', '=', $textImageItemDataSet['id'])
                  ->update($textImageItemDataSet);
            } else {
                DB::table('text_image_items')
                  ->insert($textImageItemDataSet);
            }
            self::addOrUpdateTranslations(
                $textImageItem[self::TRANSLATION],
                $textImageItemDataSet['id'],
                TextImageItem::getSubjecttypeId()
            );
        }
    }

    public static function assignTextItemsToCollectionBlock($blockId, array $textImageListDataSetIds)
    {
        foreach ($textImageListDataSetIds as $listId) {
            // $assignmentFound = DB::table(...)
        }
    }
}
