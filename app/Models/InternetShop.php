<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use App\Services\Aws\S3Service;
use Illuminate\Database\Eloquent\Relations\hasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;


/**
 * \App\Models\InternetShop
 *
 * @property int $id
 * @property int $name
 * @property int $banner_path
 * @property string $description
 * @property string $url
 * @property string|null $total_click
 * @method static Builder|InternetShop newModelQuery()
 * @method static Builder|InternetShop newQuery()
 * @method static Builder|InternetShop query()
 * @mixin Eloquent
 */

class InternetShop extends AbstractModel
{

    use SoftDeletes;

    protected $table = 'internet_shops';

    protected $appends = [
        'banner_url',
        'liked',
        'disliked',
    ];

    protected $fillable = [
        'name',
        'banner_path',
        'description',
        'url',
        'total_click',
        'total_like',
        'total_dislike',
        'link_share',
        'status',
        'order'
    ];

    public function getBannerUrlAttribute(): string
    {
        $banner = $this->getAttribute('banner_path');
        if ($banner) {
            $s3service = new S3Service();
            return $s3service->getUri($banner);
        }
        return '';
    }

    /**
     * @return HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(InternetShopReview::class);
    }

    public function getLikedAttribute(): bool
    {
        if (Auth::user()?->id) {
            $like = $this->likes()->where('user_id', Auth::user()?->id)->first();

            return !empty($like);
        }

        return false;
    }

    public function getDislikedAttribute(): bool
    {
        if (Auth::user()?->id) {
            $like = $this->dislikes()->where('user_id', Auth::user()?->id)->first();

            return !empty($like);
        }

        return false;
    }

    public function dislikes(): HasMany
    {
        return $this->hasMany(InternetShopDislike::class, 'internet_shop_id');
    }

    public function likes(): HasMany
    {
        return $this->hasMany(InternetShopLike::class, 'internet_shop_id');
    }
}
