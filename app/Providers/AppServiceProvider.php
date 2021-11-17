<?php

namespace App\Providers;

use App\Enum\ActorType;
use App\Enum\EntityMorphType;
use App\Enum\NotificationType;
use App\Enum\TransactionableType;
use App\Models\IntroduceMemberHistories;
use App\Models\LocalInfo;
use App\Models\LocalInfoComment;
use App\Models\LocalInfoLike;
use App\Models\LocalPost;
use App\Models\LocalPostComment;
use App\Models\LocalPostLike;
use App\Models\Mission;
use App\Models\Product;
use App\Models\ProductLike;
use App\Models\ProductTop;
use App\Models\Store;
use App\Models\User;
use App\Models\UserActionable;
use App\Models\UserReview;
use App\Models\UserReviewable;
use App\Services\Chatting\Providers\ChattingServiceProvider;
use App\Services\FAQ\Providers\FAQServiceProvider;
use App\Services\Internal\Providers\InternalServiceProvider;
use App\Services\MasterData\Providers\MasterDataServiceProvider;
use App\Services\Notification\Providers\NotificationServiceProvider;
use App\Services\Product\Providers\ProductServiceProvider;
use App\Services\Statistic\Providers\StatisticServiceProvider;
use App\Services\Store\Providers\StoreServiceProvider;
use App\Services\Upload\Providers\UploadServiceProvider;
use App\Services\User\Providers\UserServiceProvider;
use App\Services\LocalPost\Providers\LocalPostServiceProvider;
use App\Services\LocalInfo\Providers\LocalInfoServiceProvider;
use App\Services\UserReviewable\Providers\UserReviewableServiceProvider;
use App\Services\ResizeImage\Providers\ResizeImageServiceProvider;
use App\Services\InternetShop\Providers\InternetShopServiceProvider;
use DB;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(UploadServiceProvider::class);
        $this->app->register(ProductServiceProvider::class);
        $this->app->register(UserServiceProvider::class);
        $this->app->register(NotificationServiceProvider::class);
        $this->app->register(StoreServiceProvider::class);
        $this->app->register(UserReviewableServiceProvider::class);
        $this->app->register(LocalPostServiceProvider::class);
        $this->app->register(LocalInfoServiceProvider::class);
        $this->app->register(MasterDataServiceProvider::class);
        $this->app->register(ChattingServiceProvider::class);
        $this->app->register(StatisticServiceProvider::class);
        $this->app->register(ResizeImageServiceProvider::   class);
        $this->app->register(FAQServiceProvider::class);
        $this->app->register(InternalServiceProvider::class);
        $this->app->register(InternetShopServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(app()->runningInConsole()) {
            // we are running in the console
            $argv = Request::server('argv', null);

            // /usr/bin/php /var/www/html/artisan migrate
            // $argv = array (
            //      0 => '/var/www/html/artisan',
            //      1 => 'migrate',
            // )
            if (count($argv) > 2) {
                if(Str::contains($argv[0],'artisan') && Str::contains($argv[1],'migrate')) {
                    DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('geography', 'string');
                    DB::getDoctrineSchemaManager()->getDatabasePlatform()->registerDoctrineTypeMapping('geometry', 'string');
                }
            }
        }
//        $this->app->bind(
//            \App\Repositories\User\UserRepositoryInterface::class,
//            \App\Repositories\User\UserRepository::class
//        );

        NotificationType::morphMap();
        TransactionableType::morphMap();
        ActorType::morphMap();
    }
}
