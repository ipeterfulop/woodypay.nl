<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixImagesizes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hero_blocks', function (Blueprint $table) {
            $table->string('background_image', 255)->nullable()->default(null)->change();
        });
        Schema::table('cta_blocks', function (Blueprint $table) {
            $table->string('background_image', 255)->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
