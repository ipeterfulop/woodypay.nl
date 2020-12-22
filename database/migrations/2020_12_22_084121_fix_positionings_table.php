<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixPositioningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('positionings',function (Blueprint $table) {
            $table->dropUnique('positionings_is_horizontal_unique');
            $table->dropUnique('positionings_is_vertical_unique');
            $table->dropColumn('is_horizontal');
            $table->dropColumn('is_vertical');
        });
        Schema::table('positionings',function (Blueprint $table) {
            $table->tinyInteger('is_horizontal');
            $table->tinyInteger('is_vertical');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
