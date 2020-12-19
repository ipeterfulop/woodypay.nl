<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSimpleTextImageBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'simple_text_image_blocks',
            function (Blueprint $table) {
                $table->id();
                $table->string('text_color', 6)->nullable()->default(null);
                $table->string('background_color', 6)->nullable()->default(null);
                $table->string('button_background_color', 6)->nullable()->default(null);
                $table->string('button_text_color', 6)->nullable()->default(null);
                $table->unsignedBigInteger('topic_image_horizontal_positioning_id')
                      ->nullable()
                      ->default(null);
                $table->timestamps();
            }
        );

        Schema::table(
            'simple_text_image_blocks',
            function (Blueprint $table) {
                $table->foreign('topic_image_horizontal_positioning_id', 'FK_simple_text_image_blocks_01')
                      ->references('id')
                      ->on('positionings');
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
        Schema::dropIfExists('simple_text_image_blocks');
    }
}
