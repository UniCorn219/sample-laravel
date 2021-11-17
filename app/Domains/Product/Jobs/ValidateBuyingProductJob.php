<?php

namespace App\Domains\Product\Jobs;

use App\Enum\BusinessExceptionCode;
use App\Enum\ProductStatus;
use App\Exceptions\BusinessException;
use App\Models\Product;
use Lucid\Units\Job;
use Throwable;

class ValidateBuyingProductJob extends Job
{
    private Product $product;
    private int $paymentMethod;

    public function __construct(Product $product, int $paymentMethod)
    {
        $this->product       = $product;
        $this->paymentMethod = $paymentMethod;
    }

    /**
     * @throws Throwable
     */
    public function handle()
    {
        $methods = $this->product->paymentMethods->pluck('payment_method');
        throw_if(
            !$methods->contains($this->paymentMethod),
            BusinessException::class,
            __('messages.payment.product_not_accept_payment_method'),
            BusinessExceptionCode::PRODUCT_NOT_ACCEPT_PAYMENT_METHOD
        );

        $availableStatuses = collect([ProductStatus::SELLING, ProductStatus::RESERVED]);
        throw_if(
            !$availableStatuses->contains($this->product->status),
            BusinessException::class,
            __('messages.payment.product_status_can_not_buy'),
            BusinessExceptionCode::PRODUCT_CAN_NOT_BUY
        );
    }
}
