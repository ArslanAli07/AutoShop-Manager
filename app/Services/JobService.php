<?php

namespace App\Services;

use App\Models\Job;

class JobService
{
    /**
     * Generate unique job number: JC-YYYY-XXXX
     */
    public function generateJobNumber(): string
    {
        $year = date('Y');
        $lastJob = Job::where('job_number', 'like', "JC-{$year}-%")
            ->orderBy('id', 'desc')
            ->first();

        $sequence = 1;
        if ($lastJob) {
            $parts = explode('-', $lastJob->job_number);
            $sequence = (int)($parts[2] ?? 0) + 1;
        }

        return "JC-{$year}-" . str_pad((string)$sequence, 4, '0', STR_PAD_LEFT);
    }
}
