<?php

namespace App\Domains\Transaction\Jobs;

use App\Models\ProductTransactionable;
use Illuminate\Database\Eloquent\Model;
use Lucid\Units\Job;

class CreateProductTransactionableJob extends Job
{
    public function __construct(
        private int $productId,
        private int $sellerId,
        private int $paymentMethod,
        private int $orderStatus,
        private ?int $buyerId = null,
        private ?string $recipientName = null,
        private ?string $recipientPhone = null,
        private ?string $recipientPostcode = null,
        private ?string $recipientAddress = null,
        private ?string $recipientAddressDetail = null,
        private ?string $note = null,
        private ?string $shippingCompanyName = null,
        private ?string $billOfLandingNo = null,
        private ?string $deliveryDate = null,
        private ?string $txid = null,
    ) {
    }

    public function handle(): Model|ProductTransactionable
    {
        return ProductTransactionable::create([
            'product_id'               => $this->productId,
            'seller_id'                => $this->sellerId,
            'payment_method'           => $this->paymentMethod,
            'buyer_id'                 => $this->buyerId,
            'recipient_name'           => $this->recipientName,
            'recipient_phone'          => $this->recipientPhone,
            'recipient_postcode'       => $this->recipientPostcode,
            'recipient_address'        => $this->recipientAddress,
            'recipient_address_detail' => $this->recipientAddressDetail,
            'note'                     => $this->note,
            'shipping_company_name'    => $this->shippingCompanyName,
            'bill_of_landing_no'       => $this->billOfLandingNo,
            'delivery_date'            => $this->deliveryDate,
            'txid'                     => $this->txid,
            'order_status'             => $this->orderStatus,
        ]);
    }
}
