<?php

namespace Database\Seeders;

use App\Enum\DynamicLinkObject;
use App\Models\User;
use App\Services\Firebase\DynamicLinkService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class UserLinkShareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        User::chunk(1200, function ($users) {
            $data = [];
            foreach ($users as $user) {
                $dynamicLinks = resolve(DynamicLinkService::class)->handle(DynamicLinkObject::USER, $user->id);
                $userArray = $user->toArray();
                unset($userArray['avatar_url']);
                unset($userArray['is_block_chatting']);
                unset($userArray['refer_link']);
                $userArray['link_share'] = $dynamicLinks['shortLink'];
                array_push($data, $userArray);
            }
            User::upsert($data, ['id'], ['link_share']);
        });
    }
}
