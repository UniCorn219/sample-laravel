<?php

namespace App\Domains\Chatting\Jobs\User;

use App\Models\User;
use App\Models\Firestore\User as FirebaseUser;
use Lucid\Units\Job;

class CreateFirestoreUserJob extends Job
{
    private User $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return string
     */
    public function handle(): string
    {
        $address = $this->user->address()->first();
        $address = $address ? $address->emd_name : '';

        $data = [
            'user_id'  => $this->user->id,
            'name'     => $this->user->name,
            'nickname' => $this->user->nickname,
            'phone'    => $this->user->phone,
            'avatar'   => $this->user->avatar_url,
            'address'  => $address,
            'uniqid'   => $this->user->uniqid,
        ];

        return FirebaseUser::query()->insertGetId($data);
    }
}
