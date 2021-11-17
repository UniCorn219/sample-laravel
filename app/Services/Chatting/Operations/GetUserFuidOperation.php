<?php

namespace App\Services\Chatting\Operations;

use App\Domains\Chatting\Jobs\User\CreateFirestoreUserJob;
use App\Models\User;
use App\Models\Firestore\User as FirestoreUser;
use Exception;
use Lucid\Units\Operation;
use function PHPUnit\Framework\isEmpty;

class GetUserFuidOperation extends Operation
{
    private int $userId;
    /**
     * Create a new operation instance.
     *
     * @return void
     */
    public function __construct(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * Find user in database
     * Check user has firebase_uid value
     * If not check user exist in firestore else return firebase_uid value.
     *
     * If user already exist just update `firebase_uid` field corresponding user in database
     * else create user in firestore and then update `firebase_uid` field.
     *
     * @return string
     * @throws Exception
     */
    public function handle(): string
    {
        $user = User::query()->findOrFail($this->userId);

        if (empty($user->firebase_uid)) {
            $firestoreUser = $this->findUserInFirestore();

            if (is_null($firestoreUser)) {
                $docId = $this->run(CreateFirestoreUserJob::class, ['user' => $user]);
            } else {
                $docId = $firestoreUser->id;
            }

            $user->firebase_uid = $docId;
            $user->save();
        } else {
            $userData = $this->formatUserData($user);
            $this->syncUserFirebase($userData, $user->firebase_uid);
        }

        return $user->firebase_uid;
    }

    private function formatUserData(User $user)
    {
        $address = $user->address()->first();
        $address = $address ? $address->emd_name : '';

        return [
            'user_id'  => $user->id,
            'name'     => $user->name,
            'nickname' => $user->nickname,
            'phone'    => $user->phone,
            'avatar'   => $user->avatar_url,
            'address'  => $address,
            'uniqid'   => $user->uniqid,
        ];
    }

    private function syncUserFirebase(array $data, string $firebaseUid)
    {
        FirestoreUser::query()->insertWithId($data, $firebaseUid);
    }

    /**
     * @throws Exception
     */
    public function findUserInFirestore()
    {
        return FirestoreUser::findById($this->userId);
    }
}
