<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('translationsubjecttypes', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subjecttype_id')->nullable()->default(null);
            $table->unsignedBigInteger('subject_id')->nullable()->default(null);
            $table->char('locale_id', 2);
            $table->text('translation');
            $table->text('key');
            $table->string('field')->nullable();
            $table->timestamps();
        });
        Schema::table('translations', function (Blueprint $table) {
            $table->foreign('subjecttype_id')->references('id')->on('translationsubjecttypes');
            $table->foreign('locale_id')->references('id')->on('locales');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('translations');
    }
}
