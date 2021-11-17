<?php

namespace Database\Seeders;

use App\Services\Aws\S3Service;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('missions')->truncate();
        $dataInsert = [];
        $s3Service = new S3Service();

        $missionDefault = [
            ['나는야 후기 수집가', '거래 후 후기 100회 받기', '100', '10'],
            ['거래는 떴다에서', '떴다마켓에서 제공하는 대리점에서 거래 50회', '100', '50'],
            ['믿고 거래하세요!', '배터리 5단계 100일 달성자', '50', '100'],
            ['친화력 만랩', '댓글, 게시글 100회 작성', '100', '20'],
            ['내가 인간 다이소', '판매 물품 100개 등록', '100', '30'],
            ['인싸의 시작', '팔로잉 10명 모음', '50', '30'],
            ['우리 벌써 이렇게?', '떴다마켓 가입후 1년 지난 사용자', '100', '100'],
            ['휴대폰 수집가', '떴다마켓에서 휴대폰 30회 구매', '100', '50'],
            ['인싸의 길', '팔로잉 100명 모음', '100', '20'],
            ['아싸에서 인싸로', '팔로잉 10회 하기', '50', '50'],
            ['모범 시민상', '거래금지물품, 욕설 등 신고 50회하기', '50', '50'],
            ['넌 내가 칭찬해', '거래후 후기 판매자에게 100회 작성', '100', '50'],
        ];

        foreach ($missionDefault as $key => $mission) {
            $i = $key + 1;
            $iconUrl = "icon/mission_{$i}_inactive.png";
            $s3Service->uploadByKey(resource_path("images/$iconUrl"), $iconUrl);
            $activeIconUrl = "icon/mission_$i.png";
            $s3Service->uploadByKey(resource_path("images/$activeIconUrl"), $activeIconUrl);
            $descUrl = "icon/mission_{$i}_desc.png";
            $s3Service->uploadByKey(resource_path("images/$descUrl"), $descUrl);
            $descActiveUrl = "icon/mission_{$i}_desc_active.png";
            $s3Service->uploadByKey(resource_path("images/$descActiveUrl"), $descActiveUrl);

            array_push($dataInsert, [
                'title' => $mission[0],
                'description' => $mission[1],
                'point' => (int) $mission[2], // FTSY
                'battery_point' => (int) $mission[3],
                'icon_url' => $iconUrl,
                'active_icon_url' => $activeIconUrl,
                'desc_icon_url' => $descUrl,
                'desc_active_icon_url' => $descActiveUrl,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        DB::table('missions')->insert($dataInsert);
    }
}
