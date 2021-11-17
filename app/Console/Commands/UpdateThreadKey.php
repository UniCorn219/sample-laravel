<?php

namespace App\Console\Commands;

use App\Domains\Chatting\Jobs\UpdateThreadJob;
use App\Helpers\Common;
use App\Models\Firestore\Thread;
use Illuminate\Console\Command;

class UpdateThreadKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'thread:key:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Thread key';

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
        $bar = $this->output->createProgressBar(count($threads));

        $bar->start();
        foreach ($threads as $thread) {
            $this->info('PROCESSING THREAD: ' . $thread->id);

            $productId = $thread->has_product ? $thread->product['id'] : null;


            $firstUserFuid = $thread->participants[0]['id'];
            $secondUserFuid = $thread->participants[1]['id'];

            $newKey = Common::generateThreadKey([
                $firstUserFuid,
                $secondUserFuid,
            ], $productId);

            $this->info('OLD KEY: ' . $thread->key);
            $this->info('NEW KEY: ' . $newKey);

            Thread::query()->update(['key' => $newKey], $thread->id);

            $bar->advance();
        }

        $bar->finish();
    }
}
