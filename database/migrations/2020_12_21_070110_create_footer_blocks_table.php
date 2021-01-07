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

                $table->text('site_logo')->nullable()->default(null);
                $table->text('row_2_content_1')->nullable()->default(null);
                $table->text('row_2_content_2')->nullable()->default(null);
                $table->text('row_2_content_3')->nullable()->default(null);
                $table->text('row_2_content_4')->nullable()->default(null);
                $table->text('row_3_content_1_copyright')->nullable()->default(null);
                $table->text('row_3_content_2_imprint')->nullable()->default(null);
                $table->text('row_3_content_3_terms_of_use')->nullable()->default(null);
                $table->text('row_3_content_4_privacy')->nullable()->default(null);

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
