<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matchings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('company_id')->comment('会社ID');
            $table->string('project_name', 100)->comment('案件名');
            $table->text('project_content')->comment('案件内容');
            $table->string('budget', 100)->nullable()->comment('予算');
            $table->text('comment')->nullable()->comment('コメント');
            $table->string('desired_delivery_date', 100)->comment('希望納期');
            $table->unsignedTinyInteger('status')->comment('ステータス');
            $table->string('responsible_name', 100)->nullable()->comment('担当者名');
            $table->string('department', 100)->nullable()->comment('担当者部署名');
            $table->string('mail', 100)->nullable()->comment('メールアドレス');
            $table->string('tel', 50)->nullable()->comment('電話番号');
            $table->string('meeting_method', 255)->nullable()->comment('打ち合わせ方法');
            $table->timestamp('disp_start_date')->comment('受付開始日');
            $table->timestamp('disp_end_date')->comment('受付終了日');

            $table->bigInteger('create_user_id')->nullable()->comment('作成者');
            $table->timestamp('created_at')->comment('作成日');
            $table->bigInteger('update_user_id')->nullable()->comment('更新者');
            $table->timestamp('updated_at')->comment('更新日');
            $table->bigInteger('delete_user_id')->nullable()->comment('削除者');
            $table->timestamp('deleted_at')->nullable()->comment('削除日');
            $table->index(['company_id'], 'idx_company_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('matchings');
    }
}
