<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTextImageListCollectionBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'text_image_list_collection_blocks',
            function (Blueprint $table) {
                $table->foreignId('id')->constrained('blocks')->primary();

                $table->string('text_color_selected_list', 25)->nullable()->default(null);
                $table->string('background_color_selected_list', 25)->nullable()->default(null);
                $table->string('background_gradient_selected_list')->nullable()->default(null);

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
        Schema::dropIfExists('text_image_list_collection_blocks');
    }
}
