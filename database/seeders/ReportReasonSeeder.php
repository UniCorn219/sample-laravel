<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use DB;

class ReportReasonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return boolean
     */
    public function run()
    {
        DB::table('report_reason')->truncate();

        $data = [
            ['reason' => '부적절한 홍보 게시물', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['reason' => '청소년에게 부적합한 내용', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['reason' => '심한 비방/욕설', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
            ['reason' => '낚시성/도배/무의미한 짧은 글', 'created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')],
        ];

        DB::table('report_reason')->insert($data);

        return true;
    }
}
