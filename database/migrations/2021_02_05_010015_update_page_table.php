<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table(
            'pages',
            function (Blueprint $table) {
                $table->foreignId('parent_page_id')->nullable()->default(null);
                $table->foreignId('redirect_to_page_id')->nullable()->default(null);
                $table->text('title')->nullable()->default(null);
                $table->text('description')->nullable()->default(null);
            }
        );
        Schema::table(
            'pages',
            function (Blueprint $table) {
                $table->foreign('parent_page_id')
                      ->references('id')
                      ->on('pages');
                $table->foreign('redirect_to_page_id')
                      ->references('id')
                      ->on('pages');
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
        Schema::table(
            'pages',
            function (Blueprint $table) {
                //
            }
        );
    }
}
