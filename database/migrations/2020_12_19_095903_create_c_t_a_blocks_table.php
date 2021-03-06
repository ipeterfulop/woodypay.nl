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
                $table->foreignId('id')->constrained('blocks')->primary();

                $table->string('background_image', 25)->nullable()->default(null);
                $table->unsignedBigInteger('spacing_id')->nullable()->default(null);

                $table->timestamps();
            }
        );

        Schema::table(
            'cta_blocks',
            function (Blueprint $table) {
                $table->foreign('spacing_id')
                      ->references('id')
                      ->on('spacings');
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
