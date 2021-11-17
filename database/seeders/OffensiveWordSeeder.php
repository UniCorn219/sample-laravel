<?php

namespace Database\Seeders;

use App\Models\OffensiveWord;
use Illuminate\Database\Seeder;
use Lucid\Bus\UnitDispatcher;
use PhpOffice\PhpSpreadsheet\IOFactory;

class OffensiveWordSeeder extends Seeder
{
    use UnitDispatcher;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $spreadsheet = IOFactory::load(storage_path('data/offensive.xlsx'));

        $data = collect($spreadsheet->getActiveSheet()->toArray())
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

        OffensiveWord::upsert($data, ['word', 'language_code'], ['word', 'language_code']);
    }
}
