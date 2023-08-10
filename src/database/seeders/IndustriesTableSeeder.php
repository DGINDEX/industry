<?php

namespace Database\Seeders;

use App\Industry;
use Database\Factories\IndustryFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndustriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        echo 'IndustriesTable ... ';

        Industry::flushEventListeners();
        DB::table('industries')->truncate();

        $industries = array(
            '建設業', 'エネルギー供給業', '鉱業', '農林水産業', '卸・小売業', '情報通信業', '運輸倉庫業', '金融・保険業', '飲食業','宿泊業',
            '不動産業・物品賃貸業', 'サービス', '医療・福祉', '教育・学習・研究', '団体・公務', 'その他'
        );

        //業種登録
        foreach ($industries as $industry) {
            Industry::create([
                'industry_name'           => $industry,
                'create_user_id' => 1,
                'created_at' => date('Y-m-d')
            ]);
        }
    }
}
