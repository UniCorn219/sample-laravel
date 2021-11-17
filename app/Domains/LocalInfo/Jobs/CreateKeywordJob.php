<?php

namespace App\Domains\LocalInfo\Jobs;

use App\Models\Keyword;
use Lucid\Units\Job;

class CreateKeywordJob extends Job
{
    private $keyword;

    /**
     * CreateKeywordJob constructor.
     *
     * @param string $keyword
     */
    public function __construct($keyword)
    {
        $this->keyword = $keyword;
    }

    /**
     * @return mixed
     */
    public function handle()
    {
        return Keyword::create([
            'keyword' => $this->keyword,
            'type'    => Keyword::TYPE_LOCAL
        ]);
    }
}
