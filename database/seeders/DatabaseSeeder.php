<?php

namespace Database\Seeders;

use App\Models\HeroBlock;
use App\Models\Locale;
use App\Models\Translation;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    const BLOCK = 'block';
    const EXTENDED_BLOCK = 'extendedBlock';
    const TRANSLATION = 'translation';

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
    public static function getDefaultBlockDataSet(int $blocktypeId, int $id = null, bool $isDarkTheme = false): array
    {
        $dataSet = [
            DatabaseSeeder::BLOCK          => [
                'id'                                   => $id,
                'blocktype_id'                         => $blocktypeId,
                'should_open_button_url_in_new_window' => 1,
                'created_at'                           => \Carbon\Carbon::now(),
                'updated_at'                           => \Carbon\Carbon::now(),
            ],
            DatabaseSeeder::EXTENDED_BLOCK => [
                'id'         => $id,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ],
            DatabaseSeeder::TRANSLATION    => [

            ],
        ];

        if ($isDarkTheme) {
            $dataSet[DatabaseSeeder::BLOCK]['text_color'] = 'rgba(232, 226, 225, 1)';
            $dataSet[DatabaseSeeder::BLOCK]['background_color'] = 'rgba(27, 34, 48, 1)';
            $dataSet[DatabaseSeeder::BLOCK]['background_gradient'] = null;
            $dataSet[DatabaseSeeder::BLOCK]['button_background_color'] = 'rgba(232, 226, 225, 1)';
            $dataSet[DatabaseSeeder::BLOCK]['button_text_color'] = 'rgba(232, 226, 225, 1)';
            $dataSet[DatabaseSeeder::BLOCK]['button_hover_background_color'] = 'rgba(58, 70, 101, 1)';
            $dataSet[DatabaseSeeder::BLOCK]['button_hover_text_color'] = 'rgba(27, 34, 48, 1)';
        } else {
            $dataSet[DatabaseSeeder::BLOCK]['text_color'] = '#1B2230';
            $dataSet[DatabaseSeeder::BLOCK]['background_color'] = '#E2E8E1';
            $dataSet[DatabaseSeeder::BLOCK]['background_gradient'] = null;
            $dataSet[DatabaseSeeder::BLOCK]['button_background_color'] = '#1B2230';
            $dataSet[DatabaseSeeder::BLOCK]['button_text_color'] = '#FFFFFF';
            $dataSet[DatabaseSeeder::BLOCK]['button_hover_background_color'] = '#3A4665';
            $dataSet[DatabaseSeeder::BLOCK]['button_hover_text_color'] = '#FFFFFF';
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

        DatabaseSeeder::addOrUpdateTranslations(
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

}
