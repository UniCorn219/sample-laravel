<?php

namespace App\Domains\Product\Jobs;

use App\Enum\DynamicLinkObject;
use App\Enum\ProductStatus;
use App\Models\Product;
use App\Models\UserAddress;
use App\Services\Aws\S3Service;
use App\Services\Firebase\DynamicLinkService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Lucid\Units\Job;

class CreateProductJob extends Job
{
    protected array $data;

    /**
     * @var S3Service $s3Service
     * */
    protected mixed $s3Service;


    /**
     * Create a new job instance.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
        $this->s3Service = app(S3Service::class);
    }

    /**
     * Execute the job.
     *
     * @return Model|Product
     */
    public function handle(): Product|Model
    {
        $data = $this->data;
        $currentUserId = Auth::user()->id;
        $userData = UserAddress::query()->where('user_id', $currentUserId)->first();
        $payload = [
            'author_id' => $currentUserId,
            'status'    => ProductStatus::SELLING,
        ];

        if (isset($data['location'])) {
            $location = str_replace(',', ' ', $data['location']);
            $payload['location'] = "POINT($location)";
        } else if ($userData) {
            $location = str_replace(',', ' ', $userData->location);
            $payload['location'] = "POINT($location)";
        }

        if ($userData) {
            $payload['emd_area_id'] = $userData->emd_area_id;
        }

        $post = Product::create(array_merge($data, $payload));
        $post->save();
        $dynamicLinks = resolve(DynamicLinkService::class)->handle(DynamicLinkObject::PRODUCT, $post->id);
        $post->link_share = $dynamicLinks['shortLink'];
        $post->save();

        return $post->refresh();
    }
}
