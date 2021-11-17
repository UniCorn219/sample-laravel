<?php

namespace App\Domains\Store\Jobs;

use Lucid\Units\Job;

class GenerateNewOrderingJob extends Job
{
    private string $prev;
    private string $next;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $prev, string $next)
    {
        $this->prev = $prev;
        $this->next = $next;
    }

    /**
     * @return string
     */
    public function handle(): string
    {
        $prev = $this->prev;
        $next = $this->next;
        $p = 0;
        $n = 0;
        $pos = 0;

        for ($i = 0; $p == $n; $i++) {
            $p = $i < strlen($prev) ? ord($prev[$i]) : 96;
            $n = $i < strlen($next) ? ord($next[$i]) : 123;
            $pos = $i;
        }

        $str = substr($prev, 0, $pos);

        if ($p == 96) {
            while ($n == 97) {
                $n = $pos < strlen($next) ? ord($next[$pos++]) : 123;
                $str .= 'a';
            }
            if ($n == 98) {
                $str .= 'a';
                $n = 123;
            }
        } elseif ($p + 1 == $n) {
            $str .= chr($p);
            $n = 123;
            while (($p = $pos < strlen($prev) ? ord($prev[$pos++]) : 96) == 122) {
                $str .= 'z';
            }
        }

        return $str . chr(ceil(($p + $n) / 2));
    }
}
