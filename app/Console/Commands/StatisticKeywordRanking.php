<?php

namespace App\Console\Commands;

use App\Models\Keyword;
use App\Models\KeywordRanking;
use App\Models\TopKeyword;
use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;

class StatisticKeywordRanking extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'keyword:ranking';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Statistic keyword raking in moth';

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

        DB::table('keywords')->truncate();

        return true;
    }

    public function handleKeyword($keywords, $type = Keyword::TYPE_LOCAL)
    {
        $keywords->map(function ($item) use ($type) {
            return KeywordRanking::query()->create([
                'keyword'    => $item->keyword,
                'quantity'   => $item->quantity,
                'type'       => $type,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        });

        $keywords->take(TopKeyword::MAX_TOP_KEYWORD)->map(function ($item) use ($type) {
            return TopKeyword::query()->create([
                'keyword'      => $item->keyword,
                'quantity'     => $item->quantity,
                'type'         => $type,
                'is_top_day'   => true,
                'is_top_week'  => false,
                'is_top_month' => false,
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now()
            ]);
        });
    }

    public function getKeywords($type = Keyword::TYPE_LOCAL)
    {
        return Keyword::query()
            ->select(['keyword', DB::raw('count(id) as quantity')])
            ->where('type', $type)
            ->groupBy('keyword')
            ->orderBy('quantity', 'DESC')
            ->get();
    }
}
