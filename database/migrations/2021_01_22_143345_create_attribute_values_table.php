<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'attribute_values',
            function (Blueprint $table) {
                $table->id();
                $table->foreignId('attribute_id')
                      ->constrained()
                      ->unique();
                $table->foreignId('attribute_value_set_value_id')
                      ->nullable()
                      ->default(null)
                      ->constrained('attribute_value_set_values', 'id');
                $table->text('custom_value')->nullable()->default(null);
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
        Schema::dropIfExists('attribute_values');
    }
}
