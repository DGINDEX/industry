<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->bigInteger('user_id')->comment('ユーザーID');
            $table->bigInteger('industry_id')->comment('業種ID');
            $table->string('company_name', 100)->comment('会社名');
            $table->string('company_name_kana', 100)->comment('会社名カナ');
            $table->string('zip', 100)->nullable()->comment('郵便番号');
            $table->unsignedTinyInteger('pref_code')->length(2)->nullable()->comment('都道府県コード');
            $table->string('address', 255)->nullable()->comment('住所');
            $table->string('tel', 50)->nullable()->comment('電話番号');
            $table->string('fax', 50)->nullable()->comment('FAX番号');
            $table->string('hp_url', 255)->nullable()->comment('ホームページURL');
            $table->string('representative_name', 100)->comment('代表者名');
            $table->date('founding_date')->nullable()->comment('創立年月日');
            $table->bigInteger('employees_num')->nullable()->comment('従業員数');
            $table->text('business_content')->nullable()->comment('事業内容');
            $table->text('comment')->nullable()->comment('紹介文');
            $table->string('responsible_name', 100)->nullable()->comment('担当者名');
            $table->string('department', 100)->nullable()->comment('担当者部署名');
            $table->string('mail', 100)->nullable()->comment('メールアドレス');
            $table->tinyInteger('mail_send_flg')->comment('メール送信フラグ');

            $table->bigInteger('create_user_id')->nullable()->comment('作成者');
            $table->timestamp('created_at')->comment('作成日');
            $table->bigInteger('update_user_id')->nullable()->comment('更新者');
            $table->timestamp('updated_at')->comment('更新日');
            $table->bigInteger('delete_user_id')->nullable()->comment('削除者');
            $table->timestamp('deleted_at')->nullable()->comment('削除日');

            $table->index(['user_id'], 'idx_user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies');
    }
}
