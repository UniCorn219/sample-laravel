<?php

namespace Database\Seeders;

use App\Models\TransferBank;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransferBankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = $this->listTransferBanks();

        $insert = collect($banks)->map(function ($item) {
            return [
                'name'           => $item[0],
                'account_number' => $item[1],
                'created_at'     => now(),
                'updated_at'     => now(),
            ];
        })
            ->toArray();

        DB::table('transfer_banks')->truncate();

        TransferBank::insert($insert);
    }

    public function listTransferBanks()
    {
        return [
            [
                "기업은행 Industrial Bank",
                "45104123232344",
            ],
            [
                "국민은행 Kookmin bank",
                "44323232140154",
            ],
        ];
    }
}
