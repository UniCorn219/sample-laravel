<?php

namespace App\Domains\Product\Jobs;

use Lucid\Units\Job;
use App\Models\Keyword;

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
            'type'    => Keyword::TYPE_PRODUCT
        ]);
    }
}
