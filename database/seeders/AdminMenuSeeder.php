<?php

namespace Database\Seeders;

use Datalytix\Menu\Seeds\MenuitemsSeederBase;
use Illuminate\Database\Seeder;

class AdminMenuSeeder extends MenuitemsSeederBase
{
    protected function buildMenuitemDataset()
    {
        $position = 0;
        $dataset = [
            1 => [
                'position'         => ++$position,
                'label'            => __('Administrators'),
                'parent_id'        => null,
                'url'              => null,
                'routename'        => 'vuecrud_administrator_index',
                'iconclass'        => 'template',
                'custom_view_name' => null,
                'user_gate'        => 'access-admin',
                'menuitemtype_id'  => 2,
                'tag'              => null
            ],
            2 => [
                'position'         => ++$position,
                'label'            => __('Pages'),
                'parent_id'        => null,
                'url'              => null,
                'routename'        => 'vuecrud_page_index',
                'iconclass'        => 'document',
                'custom_view_name' => null,
                'user_gate'        => 'access-admin',
                'menuitemtype_id'  => 2,
                'tag'              => null
            ],
        ];

        return $dataset;
    }
}
