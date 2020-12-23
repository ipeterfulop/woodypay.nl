<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddListIdToTextImageListBlocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('text_image_list_blocks', function (Blueprint $table) {
            $table->foreignId('list_id')->constrained('text_image_list_blocks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('text_image_list_blocks', function (Blueprint $table) {
            //
        });
    }
}
