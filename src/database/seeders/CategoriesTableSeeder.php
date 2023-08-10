<?php

namespace Database\Seeders;

use App\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        echo 'CategoriesTable ... ';
        $time_start = microtime(true);

        Category::flushEventListeners();
        DB::table('categories')->truncate();

        $categories = array(
            '光学', '食料品', '飲料品', '衣服', '医療用器具', '医療その他', '鞄・袋物', '靴・革製品', '電気機器・装置', '家電製品', '精密機械',
            'コンピュータ関連機器', 'ソフトウェア', '事務用機器', '計測機器', '通信機器', '運搬機', '自動車', '住宅', 'ゴム・タイヤ', '印刷・出版',
            '塗料・メッキ品', '家具・木製品', '工作機械', '工具・金型・ブラシ', 'プラスチック加工品', '金属', '金属加工品', '紙工品', '繊維品',
            '建築金物', '建設・建築物', '建設資材', '窯業・石材・セラミック', 'ガラス/レンズ', '化学薬品', '文具', '玩具・レジャー品', '生活雑貨',
            '自転車', '装身具', 'その他'
        );

        //カテゴリ登録
        foreach ($categories as $category) {
            Category::create([
                'category_name'           => $category,
                'create_user_id' => 1,
                'created_at' => date('Y-m-d')
            ]);
        }
    }
}
