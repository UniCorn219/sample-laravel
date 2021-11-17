<?php

namespace App\Domains\LocalPost\Jobs;

use App\Models\LocalPost;
use Illuminate\Support\Facades\DB;
use Throwable;
use Lucid\Units\Job;

class IncreaseTotalViewJob extends Job
{
    private int $id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return null|array
     * @throws Throwable
     */
    public function handle(): ?array
    {
        $id = $this->id;
        DB::transaction(function () use ($id) {
            $post = LocalPost::whereId($id)->useWritePdo()->first();
            $post->total_view += 1;
            $post->timestamps = false;
            $post->save();
        });

        $totalView = LocalPost::whereId($id)->first()->total_view;

        return ['total_view' => $totalView];
    }
}
