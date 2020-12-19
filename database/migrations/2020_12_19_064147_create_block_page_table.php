<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBlockPageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'block_page',
            function (Blueprint $table) {
                $table->id();
                $table->foreignId('page_id')->constrained('pages');
                $table->foreignId('block_id')->constrained('blocks');
                $table->unsignedInteger('position')->default(1);
                $table->timestamps();
            }
        );
        Schema::table(
            'block_page',
            function (Blueprint $table) {
                $table->unique(['page_id', 'block_id']);
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
        Schema::dropIfExists('block_pages');
    }
}
