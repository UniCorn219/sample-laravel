<?php

namespace App\Domains\Product\Jobs;

use Lucid\Units\Job;
use App\Enum\ProductStatus;
use App\Models\Transaction;
use App\Models\Product;
use App\Enum\TransactionType;
use Illuminate\Support\Facades\Auth;

class CreateTransactionJob extends Job
{
    /**
     * @var Product $product
     */
    protected Product $product;

    /**
     * @var mixed $buyerId
     */
    protected $buyerId;

    /**
     * CreateTransactionJob constructor.
     * @param $product
     * @param null $buyerId
     */
    public function __construct($product, $buyerId = null)
    {
        $this->product = $product;
        $this->buyerId = $buyerId;
    }

    /**
     * @return Void
     */
    public function handle()
    {
        if (in_array($this->product->status, [ProductStatus::SOLD, ProductStatus::COMPLETE])) {
            $existedTransaction = Transaction::where('product_id', $this->product->id)->first();

            if (!empty($this->buyerId) && !empty($existedTransaction)) {
                $existedTransaction->buyer_id = $this->buyerId;
                $existedTransaction->save();
            } else {
                Transaction::create([
                    'seller_id'  => $this->product->author_id,
                    'buyer_id'   => $this->buyerId,
                    'product_id' => $this->product->id,
                    'price'      => $this->product->price,
                    'type'       => $this->product->purchase_method
                ]);


                $product = Product::find($this->product->id);
                $product->update([
                    'buyer_id' => $this->buyerId,
                ]);
            }
        }
    }
}
