<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSignupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signups', function (Blueprint $table) {
            $table->id();
            $table->string('campaign');
            $table->char('locale', 2);
            $table->string('firstname');
            $table->string('lastname');
            $table->string('email');
            $table->date('date_of_birth');
            $table->string('phone');
            $table->unsignedBigInteger('country_id')->nullable()->default(null);
            $table->string('city')->nullable()->default(null);
            $table->string('address')->nullable()->default(null);
            $table->string('postalcode')->nullable()->default(null);
            $table->string('referralcode')->nullable()->default(null);
            $table->tinyInteger('spendingcategory_id')->nullable()->default(null);
            $table->tinyInteger('would_use_card_as_primary')->nullable()->default(null);
            $table->tinyInteger('most_attractive_feature_id')->nullable()->default(null);
            $table->tinyInteger('custom_most_attractive_feature')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('signups');
    }
}
