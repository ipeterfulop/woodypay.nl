<?php

use App\Helpers\Widthtype;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWidthtypeToBlocks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks', function (Blueprint $table) {
            $table->tinyInteger('widthtype')->default(Widthtype::CENTERED_ID);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks', function (Blueprint $table) {
            //
        });
    }
}
