<?php

namespace App\Services;

use App\Domains\Statistic\Jobs\IncreaseStatisticsUserActivityJob;
use App\Models\Media;
use App\Models\Mediable;
use App\Models\User;
use App\Services\Aws\S3Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Lucid\Units\Feature;
use App\Contracts\ResponseTrait;
use Exception;
use ReflectionClass;
use ReflectionException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BaseFeatures extends Feature
{
    use ResponseTrait;


    /**
     * @param $images
     * @param int $targetId
     * @param string $rootFolder
     * @param string $type
     * @return bool
     */
    public function uploadImage($images, int $targetId, string $rootFolder, string $type = Mediable::TYPE['LOCAL_POST']): bool
    {
        if (empty($images)) {
            Mediable::where('target_id', $targetId)
                ->where('type', $type)
                ->delete();

            return true;
        }

        $mediaInsert = [];

        foreach ($images as $image) {
            $imageId = $this->moveS3FolderAndInsertToMediaTable($image, $rootFolder);

            if (empty($imageId)) {
                throw new NotFoundHttpException("Image not found $image");
            }

            array_push($mediaInsert, [
                'target_id' => $targetId,
                'media_id' => $imageId,
                'type' => $type,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        if (count($mediaInsert)) {
            Mediable::where('target_id', $targetId)
                ->where('type', $type)
                ->delete();

            Mediable::insert($mediaInsert);
        }

        return true;
    }

    protected function moveS3FolderAndInsertToMediaTable($image, string $rootFolder): ?int
    {
        try {
            $s3Service = app(S3Service::class);
            $fileSplit = explode('.', $image);
            $fileName = $fileSplit[0];
            $fileExtension = $fileSplit[1];
            $path = "$rootFolder/$fileName/origin.$fileExtension";

            $s3Service->move("temp/$image", $path);

            $payload = [
                'name' => $fileName,
                'path' => $path,
                'extension' => $fileExtension,
                'type' => $fileExtension,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            return Media::query()->insertGetId($payload);
        } catch (Exception $e) {
            Log::error($e);
            return null;
        }
    }

    public function runInQueue($unit, array $arguments = [], $queue = '')
    {
        $connection = config('queue.default');
        $queue = $queue ?: config('queue.connections.'.$connection.'.queue');
        \Log::info('queue', [$connection, $queue]);
        // instantiate and queue the unit
        $reflection = new ReflectionClass($unit);
        $instance = $reflection->newInstanceArgs($arguments);
        $instance->onQueue((string) $queue);

        return $this->dispatch($instance);
    }

    /**
     * @throws ReflectionException
     */
    protected function increaseUserLikeStatistic(int $value = 1)
    {
        $now = Carbon::now(config('timezone.statistics_tz_offset'));
        /* @var User $user*/
        $user = auth()->user();
        $data = [
            'statistics_hour' => (int) $now->format('H') + 1,
            'statistics_date' => $now->format('Y-m-d'),
            'total_likes' => $value
        ];

        $this->runInQueue(IncreaseStatisticsUserActivityJob::class, ['data' => $data, 'user' => $user]);
    }

    /**
     * @throws ReflectionException
     */
    protected function increaseProductCompleteStatistic(int $value = 1)
    {
        $now = Carbon::now(config('timezone.statistics_tz_offset'));
        /* @var User $user*/
        $user = auth()->user();
        $data = [
            'statistics_hour' => (int) $now->format('H') + 1,
            'statistics_date' => $now->format('Y-m-d'),
            'total_product_complete' => $value
        ];

        $this->runInQueue(IncreaseStatisticsUserActivityJob::class, ['data' => $data, 'user' => $user]);
    }

    /**
     * @throws ReflectionException
     */
    protected function increaseUserProductStatistic(int $value = 1)
    {
        $now = Carbon::now(config('timezone.statistics_tz_offset'));
        /* @var User $user*/
        $user = auth()->user();
        $data = [
            'statistics_hour' => (int) $now->format('H') + 1,
            'statistics_date' => $now->format('Y-m-d'),
            'total_product' => $value
        ];

        $this->runInQueue(IncreaseStatisticsUserActivityJob::class, ['data' => $data, 'user' => $user]);
    }
}
