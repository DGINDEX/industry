<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnAltText extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('image_informations', function (Blueprint $table) {
            /* @var $table Blueprint */
            $table->text('alt_text')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('image_informations', function (Blueprint $table) {
            /* @var $table Blueprint */
            $table->string('alt_text', 255)->change();
        });
    }
}
