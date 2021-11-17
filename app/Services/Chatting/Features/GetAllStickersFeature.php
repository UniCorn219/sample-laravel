<?php

namespace App\Services\Chatting\Features;

use App\Services\Aws\S3Service;
use App\Services\BaseFeatures;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class GetAllStickersFeature extends BaseFeatures
{
    /**
     * @return JsonResponse
     */
    public function handle(): JsonResponse
    {
        $s3Service = new S3Service();
        $path = resource_path('images/stickers');
        $files = File::allFiles($path);
        $result = [];

        $cacheTheme = Cache::get(config('app.sticker_current_theme'));
        if ($cacheTheme) {
            return $this->responseOk(json_decode($cacheTheme));
        }

        foreach ($files as $file) {
            $fileNameWithoutExtension = pathinfo($file->getFilename(), PATHINFO_FILENAME);
            $key = "stickers/" . config('app.sticker_current_theme') . '/' . $file->getFilename();
            $result[$fileNameWithoutExtension] = $s3Service->getUri($key);
        }

        ksort($result, SORT_NUMERIC);
        $result = array_values($result);
        Cache::put(config('app.sticker_current_theme'), json_encode($result));

        return $this->responseOk($result);
    }
}
