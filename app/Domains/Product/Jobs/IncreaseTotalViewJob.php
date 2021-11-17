<?php

namespace App\Domains\Product\Jobs;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Lucid\Units\Job;
use Exception;
use Throwable;

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
            $post = Product::whereId($id)->useWritePdo()->first();
            $post->total_view += 1;
            $post->timestamps = false;
            $post->save();
        });

        $totalView = Product::whereId($id)->first()->total_view;

        return ['total_view' => $totalView];
    }
}
