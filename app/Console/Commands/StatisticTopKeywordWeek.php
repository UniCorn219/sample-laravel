<?php

namespace App\Console\Commands;

use App\Models\Keyword;
use App\Models\KeywordRanking;
use App\Models\TopKeyword;
use Carbon\Carbon;
use Illuminate\Console\Command;
use DB;

class StatisticTopKeywordWeek extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'top-keyword:week';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Statistic top keyword search in week';

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
        $keywordProducts = $this->getKeywords(Keyword::TYPE_PRODUCT);
        $keywordLocals   = $this->getKeywords(Keyword::TYPE_LOCAL);

        $this->handleKeyword($keywordProducts, Keyword::TYPE_PRODUCT);
        $this->handleKeyword($keywordLocals, Keyword::TYPE_LOCAL);

        return true;
    }

    public function handleKeyword($keywordRanking, $type = Keyword::TYPE_LOCAL)
    {
        $keywordRanking->map(function ($item) use ($type) {
            return TopKeyword::query()->create([
                'keyword'      => $item->keyword,
                'quantity'     => $item->quantity,
                'type'         => $type,
                'is_top_day'   => true,
                'is_top_week'  => true,
                'is_top_month' => false,
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now()
            ]);
        });
    }

    public function getKeywords($type = Keyword::TYPE_LOCAL)
    {
        return KeywordRanking::query()
            ->select(['keyword', DB::raw('sum(quantity) as quantity')])
            ->where('created_at', '>=', Carbon::now()->subWeek())
            ->where('type', $type)
            ->groupBy('keyword')
            ->orderBy('quantity', 'DESC')
            ->limit(TopKeyword::MAX_TOP_KEYWORD)
            ->get();
    }
}
