<?php

namespace App\Domains\Store\Jobs;

use App\Models\Media;
use App\Models\Mediable;
use App\Services\Aws\S3Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Lucid\Units\Job;

class UpdateStoreMediaJob extends Job
{
    private array $images;
    private int $storeId;
    /**
     * @var S3Service
     */
    private mixed $s3Service;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $images, int $storeId)
    {
        $this->images = $images;
        $this->storeId = $storeId;
        $this->s3Service = app(S3Service::class);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mediaInsert = [];
        foreach ($this->images as $image) {
            $imageId = $this->moveS3FolderAndInsertToMedia($image);

            if ($imageId) {
                array_push($mediaInsert, [
                    'target_id' => $this->storeId,
                    'media_id' => $imageId,
                    'type' => Mediable::TYPE['STORE'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }

        if (count($mediaInsert)) {
            Mediable::where('target_id', $this->storeId)
                ->where('type', Mediable::TYPE['STORE'])
                ->delete();

            Mediable::insert($mediaInsert);
        }
    }

    private function moveS3FolderAndInsertToMedia($image): ?int
    {
        try {
            $fileSplit = explode('.', $image);
            $fileName = $fileSplit[0];
            $fileExtension = $fileSplit[1];
            $path = "stores/$fileName/origin.$fileExtension";
            $this->s3Service->move("temp/$image", $path);
            $payload = [
                'name' => $image,
                'path' => $path,
                'extension' => $fileExtension,
                'type' => $fileExtension,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];

            return Media::query()->insertGetId($payload);
        } catch (\Exception $e) {
            Log::error($e);
            return null;
        }
    }
}
