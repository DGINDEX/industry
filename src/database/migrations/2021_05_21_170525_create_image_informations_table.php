<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateImageInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('image_informations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('no')->comment('NO');
            $table->bigInteger('company_matching_id')->comment('企業マッチングID');
            $table->tinyInteger('type')->comment('種別');
            $table->string('image_name', 100)->nullable()->comment('画像名');
            $table->string('alt_text', 255)->nullable()->comment('説明文');
            $table->index(['company_matching_id', 'type'], 'idx_company_matching_id_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('image_informations');
    }
}
