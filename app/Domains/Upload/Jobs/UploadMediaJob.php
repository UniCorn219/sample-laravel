<?php

namespace App\Domains\Upload\Jobs;

use App\Services\Aws\S3Service;
use Lucid\Units\Job;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Ramsey\Uuid\Uuid;

/**
 * @property UploadedFile[] files
 */
class UploadMediaJob extends Job
{
    protected $files;

    /**
     * @var S3Service $s3Service
     * */
    protected $s3Service;

    /**
     * Create a new job instance.
     * @param array $files
     */
    public function __construct(array $files)
    {
        $this->files = $files;
        $this->s3Service = app(S3Service::class);
    }

    /**
     * Execute the job.
     *
     */
    public function handle()
    {
        $images = [];

        foreach ($this->files as $file) {
            $filename = Uuid::uuid4()->toString() . '.' . $file->getClientOriginalExtension();
            $key = 'temp/' . $filename;
            $data = $this->s3Service->putObject($file->getRealPath(), $key);

            if ($data) {
                array_push($images, $filename);
            }
        }

        return $images;
    }
}
