<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCTABlocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'cta_blocks',
            function (Blueprint $table) {
                $table->id();
                $table->string('background_color', 25)->nullable()->default(null);
                $table->string('background_image', 25)->nullable()->default(null);
                $table->string('background_gradient')->nullable()->default(null);
                $table->string('button_background_color', 25)->nullable()->default(null);
                $table->string('button_text_color', 25)->nullable()->default(null);
                $table->unsignedTinyInteger('should_open_button_url_in_new_window')->default(0);
                $table->foreignId('spacing_id')->constrained('spacings')->nullable()->default(null);
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
        Schema::dropIfExists('cta_blocks');
    }
}
