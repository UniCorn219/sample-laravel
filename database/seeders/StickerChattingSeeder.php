<?php

namespace Database\Seeders;

use App\Services\Aws\S3Service;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class StickerChattingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $s3Service = new S3Service();
        $path = resource_path('images/stickers');
        $files = File::allFiles($path);

        foreach ($files as $file) {
            $key = "stickers/" . config('app.sticker_current_theme') . '/' . $file->getFilename();
            $s3Service->uploadByKey($file->getPathname(), $key);
        }
    }
}
