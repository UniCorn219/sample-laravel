<?php

namespace App\Models;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * \App\Models\ProductTransactionable
 *
 * @property int $id
 * @property int $seller_id
 * @property int|null $buyer_id
 * @property int $product_id
 * @property int $payment_method
 * @property string|null $recipient_name
 * @property string|null $recipient_phone
 * @property string|null $recipient_postcode
 * @property string|null $recipient_address
 * @property string|null $recipient_address_detail
 * @property string|null $note
 * @property string|null $shipping_company_name
 * @property string|null $bill_of_landing_no
 * @property string|null $delivery_date
 * @property string|null $deleted_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $txid
 * @property int $order_status
 * @property string|null $cancel_reason
 * @method static Builder|ProductTransactionable newModelQuery()
 * @method static Builder|ProductTransactionable newQuery()
 * @method static Builder|ProductTransactionable query()
 * @method static Builder|ProductTransactionable whereBillOfLandingNo($value)
 * @method static Builder|ProductTransactionable whereBuyerId($value)
 * @method static Builder|ProductTransactionable whereCancelReason($value)
 * @method static Builder|ProductTransactionable whereCreatedAt($value)
 * @method static Builder|ProductTransactionable whereDeletedAt($value)
 * @method static Builder|ProductTransactionable whereDeliveryDate($value)
 * @method static Builder|ProductTransactionable whereId($value)
 * @method static Builder|ProductTransactionable whereNote($value)
 * @method static Builder|ProductTransactionable whereOrderStatus($value)
 * @method static Builder|ProductTransactionable wherePaymentMethod($value)
 * @method static Builder|ProductTransactionable whereProductId($value)
 * @method static Builder|ProductTransactionable whereRecipientAddress($value)
 * @method static Builder|ProductTransactionable whereRecipientAddressDetail($value)
 * @method static Builder|ProductTransactionable whereRecipientName($value)
 * @method static Builder|ProductTransactionable whereRecipientPhone($value)
 * @method static Builder|ProductTransactionable whereRecipientPostcode($value)
 * @method static Builder|ProductTransactionable whereSellerId($value)
 * @method static Builder|ProductTransactionable whereShippingCompanyName($value)
 * @method static Builder|ProductTransactionable whereTxid($value)
 * @method static Builder|ProductTransactionable whereUpdatedAt($value)
 * @mixin Eloquent
 */
class ProductTransactionable extends AbstractModel
{
    protected $table = 'product_transactionable';

    protected $fillable = [
        'seller_id',
        'buyer_id',
        'product_id',
        'payment_method',
        'recipient_name',
        'recipient_phone',
        'recipient_postcode',
        'recipient_address',
        'recipient_address_detail',
        'note',
        'shipping_company_name',
        'bill_of_landing_no',
        'delivery_date',
        'txid',
        'order_status',
        'cancel_reason',
    ];

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(PaymentTransaction::class, 'id', 'transactionable_id');
    }
}
