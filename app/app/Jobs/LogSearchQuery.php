<?php

namespace App\Jobs;

use App\Models\SearchLog;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class LogSearchQuery implements ShouldQueue
{
    use Queueable;

    protected $searchData;


    /**
     * Create a new job instance.
     */
    public function __construct(array $searchData)
    {
        $this->searchData = $searchData;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        SearchLog::create($this->searchData);
    }
}
