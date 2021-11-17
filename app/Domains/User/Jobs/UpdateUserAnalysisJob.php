<?php

namespace App\Domains\User\Jobs;

use App\Enum\UserAnalysisType;
use App\Models\UserAnalysis;
use Illuminate\Database\Eloquent\Model;
use Lucid\Units\Job;

class UpdateUserAnalysisJob extends Job
{
    private int $userId;
    private string $type;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $userId, string $type)
    {
        $this->userId = $userId;
        $this->type = $type;
    }

    /**
     * Execute the job.
     *
     * @return Model|UserAnalysis
     */
    public function handle(): UserAnalysis|Model
    {
        $userAnalysis = UserAnalysis::firstOrCreate(['user_id' => $this->userId]);
        switch ($this->type) {
            case UserAnalysisType::COMMENT:
                $userAnalysis->total_comment += 1;
                break;
            case UserAnalysisType::LOCAL_POST:
                $userAnalysis->total_local_post += 1;
                break;
            case UserAnalysisType::FOLLOWER:
                $userAnalysis->total_follower += 1;
                break;
            case UserAnalysisType::REGISTER_PRODUCT:
                $userAnalysis->total_product += 1;
                break;
            case UserAnalysisType::FOLLOWING:
                $userAnalysis->total_following += 1;
                break;
            case UserAnalysisType::PURCHASE_NEW_PHONES:
                $userAnalysis->total_purchase_new_phones += 1;
                break;
            case UserAnalysisType::PURCHASE_OLD_PHONES:
                $userAnalysis->total_purchase_old_phones += 1;
                break;
            case UserAnalysisType::REPORT:
                $userAnalysis->total_report += 1;
                break;
            case UserAnalysisType::REVIEW_TRANSACTION:
                $userAnalysis->total_review_transaction += 1;
                break;
        }

        $userAnalysis->timestamps = false;
        $userAnalysis->save();

        return $userAnalysis;
    }
}
