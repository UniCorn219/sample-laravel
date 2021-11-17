<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use DB;

class PointSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return boolean
     */
    public function run()
    {
        DB::table('point_settings')->truncate();

        $data = [
            ['introduce_member' => 300, 'introduce_member_bonus' => 5000, 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]
        ];

        DB::table('point_settings')->insert($data);

        return true;
    }
}
