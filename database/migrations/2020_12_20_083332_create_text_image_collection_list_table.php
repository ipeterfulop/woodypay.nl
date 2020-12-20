<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTextImageCollectionListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'text_image_collection_list',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('text_image_list_collection_block_id');
                $table->unsignedBigInteger('text_image_list_id');
                $table->unsignedInteger('position')->default(1);
                $table->timestamps();
            }
        );

        Schema::table(
            'text_image_collection_list',
            function (Blueprint $table) {
                $table->foreign('text_image_list_collection_block_id', 'FK_text_image_collection_list_01')
                      ->references('id')
                      ->on('text_image_list_collection_blocks');
                $table->foreign('text_image_list_id', 'FK_text_image_collection_list_02')
                      ->references('id')
                      ->on('text_image_lists');
                $table->unique(
                    ['text_image_list_collection_block_id', 'text_image_list_id'],
                    'UQ_text_image_collection_list_01'
                );
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
        Schema::dropIfExists('text_image_collection_list');
    }
}
