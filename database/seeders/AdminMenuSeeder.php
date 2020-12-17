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
            100 => [
                'position'         => ++$position,
                'label'            => 'Fiókok',
                'parent_id'        => null,
                'url'              => null,
                'routename'        => 'vuecrud_administrator_index',
                'iconclass'        => 'template',
                'custom_view_name' => null,
                'user_gate'        => 'access-admin',
                'menuitemtype_id'  => 2,
                'tag'              => null
            ],
            1 => [
                'position'         => ++$position,
                'label'            => 'Adminisztrátorok',
                'parent_id'        => 100,
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
                'label'            => 'Regisztrált felhasználók',
                'parent_id'        => 100,
                'url'              => null,
                'routename'        => 'vuecrud_member_index',
                'iconclass'        => 'template',
                'custom_view_name' => null,
                'user_gate'        => 'access-admin',
                'menuitemtype_id'  => 2,
                'tag'              => null
            ],
            3 => [
                'position'         => ++$position,
                'label'            => 'Aktivitások',
                'parent_id'        => 100,
                'url'              => null,
                'routename'        => 'vuecrud_useraction_index',
                'iconclass'        => 'template',
                'custom_view_name' => null,
                'user_gate'        => 'access-admin',
                'menuitemtype_id'  => 2,
                'tag'              => null
            ],
        ];

        return $dataset;
    }
}
