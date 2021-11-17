<?php

namespace Database\Seeders;

use App\Enum\DynamicLinkObject;
use App\Models\LocalInfo;
use App\Models\LocalPost;
use App\Models\Product;
use App\Models\Store;
use App\Models\User;
use App\Services\Firebase\DynamicLinkService;
use Illuminate\Database\Seeder;

class LinkShareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $localPosts = LocalPost::query()->get();
        $localPosts->map(function($localPost) {
            $dynamicLinks = resolve(DynamicLinkService::class)->handle(DynamicLinkObject::LOCAL_POST, $localPost->id);
            $localPost->link_share = $dynamicLinks['shortLink'];
            $localPost->save();
        });

        $localInfos = LocalInfo::query()->get();
        $localInfos->map(function($localInfo) {
            $dynamicLinks = resolve(DynamicLinkService::class)->handle(DynamicLinkObject::LOCAL_INFO, $localInfo->id);
            $localInfo->link_share = $dynamicLinks['shortLink'];
            $localInfo->save();
        });

        $products = Product::query()->get();
        $products->map(function($product) {
            $dynamicLinks = resolve(DynamicLinkService::class)->handle(DynamicLinkObject::PRODUCT, $product->id);
            $product->link_share = $dynamicLinks['shortLink'];
            $product->save();
        });

        $stores = Store::query()->get();
        $stores->map(function($store) {
            $dynamicLinks = resolve(DynamicLinkService::class)->handle(DynamicLinkObject::STORE, $store->id);
            $store->link_share = $dynamicLinks['shortLink'];
            $store->save();
        });
    }
}
