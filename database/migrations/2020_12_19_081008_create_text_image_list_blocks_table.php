<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTextImageListBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'text_image_list_blocks',
            function (Blueprint $table) {
                $table->id();
                $table->string('text_color', 25)->nullable()->default(null);
                $table->string('background_color', 25)->nullable()->default(null);
                $table->string('background_gradient')->nullable()->default(null);
                $table->string('topic_image')->nullable()->default(null);
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
        Schema::dropIfExists('text_image_list_blocks');
    }
}
