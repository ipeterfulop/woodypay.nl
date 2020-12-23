<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFooterBlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'footer_blocks',
            function (Blueprint $table) {
                $table->foreignId('id')->constrained('blocks')->primary();

                $table->unsignedBigInteger('social_icons_text_image_list_id')
                      ->nullable()
                      ->default(null);

                $table->timestamps();
            }
        );

        Schema::table(
            'footer_blocks',
            function (Blueprint $table) {
                $table->foreign('social_icons_text_image_list_id', 'FK_footer_blocks_01')
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
        Schema::dropIfExists('footer_blocks');
    }
}
