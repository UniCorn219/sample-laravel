<?php

namespace App\Console\Commands;

use App\Models\Firestore\Message;
use App\Models\Firestore\StoreThread;
use App\Models\Firestore\Thread;
use App\Models\Firestore\UserThread;
use Illuminate\Console\Command;
use Kreait\Laravel\Firebase\Facades\Firebase;

class MergeDuplicateThread extends Command
{
    /**
     * The name and signature of the console comand.
     *
     * @var string
     */
    protected $signature = 'thread:duplicated:merge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Merge Duplicated thread';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $threads = Thread::query()->get();
        $threadKeys = collect();

        $threads->each(function ($thread) use ($threadKeys) {
            $key = $thread->key;
            $id = $thread->id;

            $this->info('Check Key: '. $key);

            $oldThread = $threadKeys->where('key', $key)->first();

            if ($oldThread) {
                $duplicateThreadId = $id;

                $messages = $this->getMessagesByThreadId($duplicateThreadId);

                $oldThreadId = $oldThread['id'];
                $this->updateMessages($messages, $oldThreadId, $duplicateThreadId);

                $this->info('Delete Duplicate Thread: ' . $duplicateThreadId);
                $this->deleteUserThread($duplicateThreadId);
                $this->deleteStoreThread($duplicateThreadId);
                Thread::query()->delete($duplicateThreadId);
            } else {
                // push key into threadKeys
                $threadKeys->push([
                    'id'  => $id,
                    'key' => $key,
                ]);
            }
        });
    }

    private function getMessagesByThreadId($threadId)
    {
        return Message::query()->where('thread_fuid', $threadId)->get();
    }

    private function updateMessages($messages, $oldThreadId, $duplicateThreadId)
    {
        $this->info("Update " . $messages->count() . " messages with thread fuid: ". $duplicateThreadId);

        $database = Firebase::firestore()->database();
        $batch    = $database->batch();

        $values = [
            ['path' => 'thread_fuid', 'value' => $oldThreadId],
        ];

        foreach ($messages as $message) {
            $ref = Message::query()->getDocumentReference($message->id);
            $batch->update($ref, $values);
        }

        if (count($messages)) {
            $batch->commit();
        }
    }

    private function deleteUserThread($duplicateThreadId)
    {
        $userThreads = UserThread::query()->where('thread_fuid', $duplicateThreadId)->get();

        foreach ($userThreads as $userThread) {
            UserThread::query()->delete($userThread->id);
        }
    }

    private function deleteStoreThread($duplicateThreadId)
    {
        $storeThreads = StoreThread::query()->where('thread_fuid', $duplicateThreadId)->get();

        foreach ($storeThreads as $storeThread) {
            UserThread::query()->delete($storeThread->id);
        }
    }
}
