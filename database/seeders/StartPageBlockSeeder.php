<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
        $this->addOrCreateHeroBlock();
    }

    private function addOrCreateHeroBlock()
    {
        $dataSet = $this->getDefaultDarkBlockDataSet();
        $dataSet['extended_block']['id'] = 1000;
        $dataSet['extended_block']['title_en'] = 'This is the title of the introductory hero block';
        $dataSet['extended_block']['content_en'] = 'This is just sample content, some lorem ipsum words, no more. '
            . 'Sollicitudin Tellus Inceptos Etiam, Sollicitudin Tellus Inceptos Etiam.';
        $dataSet['extended_block']['button_label_en'] = 'Press me, I am a button';
        $dataSet['extended_block']['button_url_en'] = 'https://www.dutchnews.nl/';

        $dataSet['extended_block']['title_nl'] = 'Dit is de titel van het inleidende gedeelte';
        $dataSet['extended_block']['content_nl'] = 'Dit is slechts voorbeeldinhoud, enkele woorden van lorem'
            . ' ipsum, meer niet. Sollicitudin Tellus Inceptos Etiam, Sollicitudin Tellus Inceptos Etiam.';
        $dataSet['extended_block']['button_label_nl'] = 'Druk op mij, ik ben een knop.';
        $dataSet['extended_block']['button_url_nl'] = 'https://www.telegraaf.nl/';
    }

    private function getDefaultDarkBlockDataSet($id = null): array
    {
        $dataSet = [
            'block'          => [
                'blocktype_id'                         => null,
                'text_color'                           => null,
                'background_color'                     => null,
                'background_gradient'                  => null,
                'button_background_color'              => null,
                'button_text_color'                    => null,
                'should_open_button_url_in_new_window' => 1,
                'created_at'                           => \Carbon\Carbon::now(),
                'updated_at'                           => \Carbon\Carbon::now(),
            ],
            'extended_block' => [

            ],
        ];

        return $dataSet;
    }
}
