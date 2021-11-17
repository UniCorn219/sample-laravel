<?php

namespace App\Domains\Statistic\Jobs;

use App\Models\StatisticsUserKeyword;
use App\Models\User;
use App\Models\UserKeyword;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Lucid\Units\QueueableJob;
use Throwable;

class IncreaseStatisticsPostClickKeywordJob extends QueueableJob
{
    private array $data;
    private User $user;

    /**
     * Create a new job instance.
     *
     * @param array $data
     * @param User $user
     */
    public function __construct(array $data, User $user)
    {
        $this->data = $data;
        $this->user = $user;
    }


    /**
     * Execute the job.
     *
     * @throws Throwable
     */
    public function handle()
    {
        $keywords = $this->getAllKeywordOfUserMatchingContent();
        $data = [];

        foreach ($keywords as $keyword) {
            $data[] = [
                'user_id' => $this->user->id,
                'keyword' => $keyword,
                'statistics_date' => $this->data['statistics_date'],
                'total_clicks' => 1,
            ];
        }
        if (count($data)) {
            $table = StatisticsUserKeyword::query()->getModel()->getTable();
            StatisticsUserKeyword::upsert(
                $data,
                [
                    'statistics_date',
                    'keyword',
                    'user_id',
                ],
                [
                    'total_clicks' => DB::raw($table . '.total_clicks + 1'),
                ]
            );
        }
    }

    private function getAllKeywordOfUserMatchingContent(): Collection
    {
        $contents = $this->data['content'];
        $keywords = new Collection();
        foreach ($contents as $content) {
            $data = UserKeyword::join('users', 'users.id', '=', 'user_keyword.user_id')
                ->whereRaw('strpos(?, lower(keyword)) > 0', [strtolower($content)])
                ->whereNull('users.deleted_at')
                ->whereNull('user_keyword.deleted_at')
                ->select('user_keyword.keyword')
                ->get()->toArray();
            $keywords->push($data);
        }
        return $keywords->flatten()->unique();
    }
}
