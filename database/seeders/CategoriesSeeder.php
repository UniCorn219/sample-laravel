<?php

namespace Database\Seeders;

use App\Services\Aws\S3Service;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $filePath = storage_path() . '/data/category_data.csv';
        $categoryFile = fopen($filePath, 'r');
        fgetcsv($categoryFile);
        DB::table('categories')->truncate();
        $dataInsert = [];
        $s3Service = new S3Service();
        while ($row = fgetcsv($categoryFile)) {
            $key = "icon/".$row[5];
            $imagePath = resource_path("images/".$key);
            $s3Service->uploadByKey($imagePath, $key);
            array_push($dataInsert, [
                'name_en' => $row[0],
                'name_ko' => $row[1] ?? null,
                'name_vn' => $row[2] ?? null,
                'description' => $row[3] ?? null,
                'type' => is_numeric($row[4]) ? $row[4] : null,
                'icon_url' => $key,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        DB::table('categories')->insert($dataInsert);
    }
}
