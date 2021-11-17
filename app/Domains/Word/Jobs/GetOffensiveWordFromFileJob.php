<?php

namespace App\Domains\Word\Jobs;

use Illuminate\Http\UploadedFile;
use Lucid\Units\Job;
use PhpOffice\PhpSpreadsheet\IOFactory;

class GetOffensiveWordFromFileJob extends Job
{
    private UploadedFile $file;

    /**
     * Create a new job instance.
     *
     * @param  UploadedFile  $file
     */
    public function __construct(UploadedFile $file)
    {
        $this->file = $file;
    }

    /**
     * Execute the job.
     * @return array
     */
    public function handle(): array
    {
        $spreadsheet = IOFactory::load($this->file->getRealPath());

        return collect($spreadsheet->getActiveSheet()->toArray())
            ->filter(function ($item, $index) {
                return isset($item[1]) && isset($item[2]) && $index > 0;
            })
            ->map(function ($item) {
                return [
                    'word'          => $item[1],
                    'language_code' => $item[2],
                ];
            })
            ->toArray();

    }
}
