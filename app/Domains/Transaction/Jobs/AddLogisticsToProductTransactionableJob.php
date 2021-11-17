<?php

namespace App\Domains\Transaction\Jobs;

use App\Enum\ProductOrderStatus;
use App\Models\ProductTransactionable;
use Lucid\Units\Job;

class AddLogisticsToProductTransactionableJob extends Job
{
    public function __construct(
        private int $id,
        private string $shippingCompanyName,
        private string $billOfLandingNo,
        private string $deliveryDate,
    ) {
    }

    public function handle()
    {
        ProductTransactionable::where('id', $this->id)
            ->update([
                'order_status' => ProductOrderStatus::SENT_LOGISTICS,
                'shipping_company_name' => $this->shippingCompanyName,
                'bill_of_landing_no'    => $this->billOfLandingNo,
                'delivery_date'         => $this->deliveryDate,
            ]);
    }
}
