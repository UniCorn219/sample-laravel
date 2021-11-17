<?php

namespace App\Domains\Chatting\Jobs;

use App\Services\Aws\S3Service;
use Exception;
use Illuminate\Http\UploadedFile;
use Lucid\Units\Job;
use Ramsey\Uuid\Uuid;

class UploadFileS3Job extends Job
{
    private UploadedFile $image;
    private string $threadFuid;

    /**
     * Create a new operation instance.
     *
     * @param  UploadedFile  $image
     * @param  string  $threadFuid
     */
    public function __construct(UploadedFile $image, string $threadFuid)
    {
        $this->image      = $image;
        $this->threadFuid = $threadFuid;
    }

    /**
     * Execute the operation.
     *
     * @return string
     * @throws Exception
     */
    public function handle(): string
    {
        /** @var S3Service $s3Service */
        $s3Service = app(S3Service::class);

        $filename = Uuid::uuid4()->toString() . '.' . $this->image->getClientOriginalExtension();
        $key = 'threads/' . $this->threadFuid . '/' . $filename;
        $s3Service->putObject($this->image->getRealPath(), $key);

        return $s3Service->getUri($key);
    }
}
