<?php

namespace Database\Seeders;

use App\Matching;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MatchingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        echo 'MatchingsTable ... ';
        Matching::flushEventListeners();
        DB::table('matchings')->truncate();

        Matching::factory(20)->create();
    }
}
