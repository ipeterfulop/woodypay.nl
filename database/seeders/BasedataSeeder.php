<?php

namespace Database\Seeders;

use App\Models\Spacing;
use Illuminate\Database\Seeder;

class BasedataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RolesSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(LocalesSeeder::class);
        $this->call(TranslationsSeeder::class);
        $this->call(SubjecttypesSeeder::class);
        $this->call(BlockTypesSeeder::class);
        $this->call(PagesSeeder::class);
        $this->call(PositioningsSeeder::class);
        $this->call(SpacingsSeeder::class);
        $this->call(StartPageBlockSeeder::class);
        $this->copyAssetImages();
    }

    protected function copyAssetImages()
    {
        $source = public_path('images'.DIRECTORY_SEPARATOR.'assets');
        $target = storage_path('app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'attachments');
        $images = scandir($source);

        foreach ($images as $image) {
            if (is_file($source.DIRECTORY_SEPARATOR.$image)) {
                if (!file_exists($target.DIRECTORY_SEPARATOR.$image)) {
                    copy($source.DIRECTORY_SEPARATOR.$image, $target.DIRECTORY_SEPARATOR.$image);
                }
            }
        }
    }
}
