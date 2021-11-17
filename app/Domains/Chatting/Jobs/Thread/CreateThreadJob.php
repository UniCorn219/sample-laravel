<?php

namespace App\Domains\Chatting\Jobs\Thread;

use App\Models\Firestore\StoreProfile;
use App\Models\Firestore\Thread;
use App\Models\Firestore\User;
use App\Models\LocalInfo;
use App\Models\Product;
use DateTime;
use Google\Cloud\Core\Timestamp;
use Lucid\Units\Job;

class CreateThreadJob extends Job
{
    private Product|LocalInfo|null $product;

    private string $userFuid;

    private string $otherUserFuid;

    private string $storeFuid;

    private string $key;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        string $userFuid,
        Product|LocalInfo|null $product,
        string $key,
        string $otherUserFuid = '',
        string $storeFuid = ''
    )
    {
        $this->product       = $product;
        $this->userFuid      = $userFuid;
        $this->otherUserFuid = $otherUserFuid;
        $this->storeFuid     = $storeFuid;
        $this->key           = $key;
    }

    /**
     * Execute the job.
     *
     * @return string
     */
    public function handle(): string
    {
        $productInfo = is_null($this->product) ? null : [
            'id'              => $this->product->id,
            'name'            => $this->product->title,
            'status'          => $this->product->status,
            'purchase_method' => $this->product->purchase_method,
            'owner_id'        => $this->product->author_id
        ];

        $participants = [];

        // User id is always
        $participants[] = [
            'id'   => $this->userFuid,
            'user' => User::query()->getDocumentReference($this->userFuid),
        ];

        if ($this->otherUserFuid) {
            $participants[] = [
                'id'   => $this->otherUserFuid,
                'user' => User::query()->getDocumentReference($this->otherUserFuid),
            ];
        }

        if ($this->storeFuid) {
            $participants[] = [
                'id'    => $this->storeFuid,
                'store' => StoreProfile::query()->getDocumentReference($this->storeFuid)
            ];
        }

        $data = [
            'key'          => $this->key,
            'participants' => $participants,
            'product'      => $productInfo,
            'has_product'  => !is_null($this->product),
            'buyer_fuid'   => is_null($this->product) ? null : $this->userFuid,
            'seller_fuid'  => is_null($this->product) ? null : ($this->otherUserFuid ?: $this->storeFuid),
            'created_at'   => new Timestamp(new DateTime()),
            'updated_at'   => new Timestamp(new DateTime()),
        ];

        return Thread::query()->insertGetId($data);
    }
}
