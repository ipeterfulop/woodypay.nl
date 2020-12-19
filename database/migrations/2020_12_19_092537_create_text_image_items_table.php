<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTextImageItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'text_image_items',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('text_image_list_id');
                $table->unsignedInteger('position')->default(1);
                $table->string('topic_image')->nullable()->default(null);
                $table->string('fa_icon_classes')->nullable()->default(null);
                $table->timestamps();
            }
        );

        Schema::table(
            'text_image_items',
            function (Blueprint $table) {
                $table->foreign('text_image_list_id')
                      ->references('id')
                      ->on('text_image_lists');
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
        Schema::dropIfExists('text_image_items');
    }
}
