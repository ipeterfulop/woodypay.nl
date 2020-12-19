<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeroBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'hero_blocks',
            function (Blueprint $table) {
                $table->id();
                $table->string('text_color', 25)->nullable()->default(null);
                $table->string('background_color', 25)->nullable()->default(null);
                $table->string('background_image', 25)->nullable()->default(null);
                $table->string('background_gradient')->nullable()->default(null);
                $table->foreignId('background_image_positioning_id')
                      ->constrained('positionings')
                      ->nullable()
                      ->default(null);
                $table->string('button_background_color', 25)->nullable()->default(null);
                $table->string('button_text_color', 25)->nullable()->default(null);
                $table->timestamps();
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hero_blocks');
    }
}
