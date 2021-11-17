<?php

namespace App\Domains\Chatting\Jobs;

use Exception;
use Illuminate\Http\UploadedFile;
use Lucid\Units\Job;
use Ramsey\Uuid\Uuid;

class UploadFileStorageJob extends Job
{
    private UploadedFile $image;

    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(UploadedFile $image)
    {
        $this->image = $image;
    }

    /**
     * Execute the operation.
     *
     * @return string
     * @throws Exception
     */
    public function handle(): string
    {
        $filename = $this->randomFileName();
        $filePath = $this->getFilePath($filename);

        $localFolder = public_path('firebase-temp-uploads') . '/';

        if ($this->image->move($localFolder, $filename)) {
            $localPath = $localFolder . $filename;
            $uploadedFile = fopen($localPath, 'r');

            app('firebase.storage')->getBucket()->upload($uploadedFile, ['name' => $filePath]);
            unlink($localPath);
            return $filePath;
        } else {
            throw new Exception('can_not_move_file');
        }
    }

    private function getFilePath(string $filename): string
    {
        $firebaseStoragePath = 'threads/';

        return $firebaseStoragePath . $filename;
    }

    private function randomFileName(): string
    {
        $name = Uuid::uuid4();
        $extension = $this->image->getClientOriginalExtension();

        return $name . '.' . $extension;
    }
}
