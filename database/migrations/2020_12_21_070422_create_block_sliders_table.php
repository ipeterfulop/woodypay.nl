<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlockSlidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'block_sliders',
            function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('slider_id');
                $table->unsignedBigInteger('block_id');
                $table->unsignedInteger('position')->default(1);
                $table->timestamps();
            }
        );

        Schema::table(
            'block_sliders',
            function (Blueprint $table) {
                $table->foreign('slider_id')
                      ->references('id')
                      ->on('slider_blocks');
                $table->foreign('block_id')
                      ->references('id')
                      ->on('blocks');
                $table->unique(['slider_id', 'block_id']);
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
        Schema::dropIfExists('block_sliders');
    }
}
