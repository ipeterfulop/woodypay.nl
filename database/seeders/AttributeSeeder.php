<?php

namespace Database\Seeders;

use App\DatabaseSeedingAction;
use App\Models\Attributegroup;
use App\Models\Datatype;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->addOrUpdateDatatypes();
        $this->addOrUpdateAttributeGroups();
        $this->addOrUpdateAttributes();
    }

    private function addOrUpdateDatatypes()
    {
        $datatypesDataSet = [
            ['id' => Datatype::INTEGER_ID, 'name' => 'Integer',],
            ['id' => Datatype::FLOAT_ID, 'name' => 'Float',],
            ['id' => Datatype::STRING_ID, 'name' => 'String',],
            ['id' => Datatype::TEXT_ID, 'name' => 'Text',],
            ['id' => Datatype::BOOLEAN_ID, 'name' => 'Boolean',],
            ['id' => Datatype::DATE_ID, 'name' => 'Date',],
            ['id' => Datatype::TIME_ID, 'name' => 'Time',],
            ['id' => Datatype::COLOR_ID, 'name' => 'Color',],
            ['id' => Datatype::IMAGE_ID, 'name' => 'Image file',],
        ];

        $table = 'datatypes';
        $fieldsToUse = ['id', 'name'];
        $translatedField = 'name';

        foreach ($datatypesDataSet as $datatype) {
            $datatypeRow = collect($datatype)->only($fieldsToUse)->all();
            DatabaseSeedingAction::insertOrUpdateRecord($table, $datatypeRow);
            $subjectId = $datatype['id'];
            $subjecttypeId = Datatype::SUBJECTTYPE_ID;
            $translationRow = [
                'id'             => Datatype::SUBJECTTYPE_ID * 100 + $datatype['id'],
                'locale_id'      => 'en',
                'subjecttype_id' => $subjecttypeId,
                'subject_id'     => $subjectId,
                'field'          => $translatedField,
                'key'            => $subjectId . '-' . $subjecttypeId . '-' . $translatedField,
                'translation'    => $datatype[$translatedField],
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),

            ];
            DatabaseSeedingAction::insertOrUpdateRecord('translations', $translationRow);
        }
    }

    private function addOrUpdateAttributeGroups()
    {
        $attributeGroupDataSet = [
            [
                'id'            => 1,
                'name'          => 'Page header',
                'variable_name' => 'page_header',
                'description'   => 'Set website header height, background color and logo',
                'translations'  => [
                    'en' => [
                        'name'        => 'Page header',
                        'description' => 'Set website header height, background color and logo',
                    ],
                    'nl' => [
                        'name'        => 'Pagina hoofd',
                        'description' => 'Stel de hoogte van de websiteheader, achtergrondkleur en logo in',
                    ],
                ],
            ],
            [
                'id'            => 2,
                'name'          => 'Registration pages (Viral loop)',
                'variable_name' => 'registration_form',
                'description'   => 'Settings for the registration pages',
                'translations'  => [
                    'en' => [
                        'name'        => 'Registration pages (Viral loop)',
                        'description' => 'Settings for the registration pages',
                    ],
                    'nl' => [
                        'name'        => 'Inschrijfformulier (virale lus)',
                        'description' => 'Instellingen voor de registratiepagina\'s',
                    ],
                ],
            ],
        ];

        $table = 'attributegroups';
        $fieldsToUse = ['id', 'name', 'variable_name', 'description'];
        $fieldsToTranslate = ['name', 'description'];
        foreach ($attributeGroupDataSet as $attributeGroupRow) {
            $dataRow = collect($attributeGroupRow)->only($fieldsToUse)->all();
            DatabaseSeedingAction::insertOrUpdateRecord($table, $dataRow);
            foreach ($fieldsToTranslate as $translatedField) {
                $subjectId = $dataRow['id'];
                $subjecttypeId = Attributegroup::SUBJECTTYPE_ID;
                $translationRow = [
                    'id'             => Datatype::SUBJECTTYPE_ID * 100 + $dataRow['id'],
                    'locale_id'      => 'en',
                    'subjecttype_id' => $subjecttypeId,
                    'subject_id'     => $subjectId,
                    'field'          => $translatedField,
                    'key'            => $subjectId . '-' . $subjecttypeId . '-' . $translatedField,
                    'translation'    => $dataRow[$translatedField],
                    'created_at'     => Carbon::now(),
                    'updated_at'     => Carbon::now(),

                ];
                DatabaseSeedingAction::insertOrUpdateRecord('translations', $translationRow);
            }
        }
    }

    private function addOrUpdateAttributes()
    {
        $attributesDataset = [
            [
                'id'                => 1,
                'name'              => 'header_height',
                'label'             => 'Height',
                'datatype_id'       => Datatype::INTEGER_ID,
                'is_translatable'   => 0,
                'attributegroup_id' => 1,
            ],
            [
                'id'                => 2,
                'name'              => 'header_background_color',
                'label'             => 'Background color',
                'datatype_id'       => Datatype::COLOR_ID,
                'is_translatable'   => 0,
                'attributegroup_id' => 1,
            ],
            [
                'id'                => 3,
                'name'              => 'header_logo',
                'label'             => 'Logo image file',
                'datatype_id'       => Datatype::IMAGE_ID,
                'is_translatable'   => 1,
                'attributegroup_id' => 1,
            ],
        ];
        $table = 'attributes';
        $fieldsToUse = array_keys($attributesDataset[0]);

        foreach ($attributesDataset as $attributeRow) {
            $dataRow = collect($attributeRow)->only($fieldsToUse)->all();
            DatabaseSeedingAction::insertOrUpdateRecord($table, $dataRow);
        }
    }


}
