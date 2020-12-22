<?php

namespace Database\Seeders;

use App\Models\Positioning;
use Illuminate\Database\Seeder;

class PositioningsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataset = [
            ['name' => 'Left top', 'code' => 'left top', 'is_horizontal' => 1, 'is_vertical' => 1],
            ['name' => 'Left center', 'code' => 'left center', 'is_horizontal' => 1, 'is_vertical' => 1],
            ['name' => 'Left bottom', 'code' => 'left bottom', 'is_horizontal' => 1, 'is_vertical' => 1],
            ['name' => 'Right top', 'code' => 'right top', 'is_horizontal' => 1, 'is_vertical' => 1],
            ['name' => 'Right center', 'code' => 'right center', 'is_horizontal' => 1, 'is_vertical' => 1],
            ['name' => 'Right bottom', 'code' => 'right bottom', 'is_horizontal' => 1, 'is_vertical' => 1],
            ['name' => 'Center top', 'code' => 'center top', 'is_horizontal' => 1, 'is_vertical' => 1],
            ['name' => 'Center center', 'code' => 'center center', 'is_horizontal' => 1, 'is_vertical' => 1],
            ['name' => 'Center bottom', 'code' => 'center bottom', 'is_horizontal' => 1, 'is_vertical' => 1],
            ['name' => 'Horizontal left', 'code' => 'left', 'is_horizontal' => 1, 'is_vertical' => 0],
            ['name' => 'Horizontal right', 'code' => 'right', 'is_horizontal' => 1, 'is_vertical' => 0],
            ['name' => 'Vertical top', 'code' => 'top', 'is_horizontal' => 0, 'is_vertical' => 1],
            ['name' => 'Vertical bottom', 'code' => 'bottom', 'is_horizontal' => 0, 'is_vertical' => 1],
        ];

        foreach ($dataset as $row) {
            Positioning::updateOrCreateWithTranslations(['code' => $row['code']], $row);
        }
    }
}
