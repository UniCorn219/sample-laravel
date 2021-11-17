<?php

namespace App\Domains\LocalPost\Jobs;

use App\Models\Keyword;
use Illuminate\Database\Eloquent\Model;
use Lucid\Units\Job;

class CreateKeywordJob extends Job
{
    private string $keyword;

    /**
     * CreateKeywordJob constructor.
     *
     * @param string $keyword
     */
    public function __construct(string $keyword)
    {
        $this->keyword = $keyword;
    }

    /**
     * @return Model|Keyword
     */
    public function handle(): Model|Keyword
    {
        return Keyword::create([
            'keyword' => $this->keyword,
            'type'    => Keyword::TYPE_LOCAL
        ]);
    }
}
