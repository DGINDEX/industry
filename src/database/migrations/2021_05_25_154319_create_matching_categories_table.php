<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchingCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matching_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('matching_id')->comment('マッチングID');
            $table->bigInteger('category_id')->comment('カテゴリID');
            $table->index('matching_id', 'idx_matching_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matching_categories');
    }
}
