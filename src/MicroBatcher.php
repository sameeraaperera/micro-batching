<?php

declare(strict_types=1);

class MicroBatcher
{
    /**
     * Maximum size of a micro batch
     *
     * @var int
     */
    private $batchSize;

    /**
     * Maximum time period in seconds between the 1st and the last job in a micro batch
     *
     * @var inta
     */
    private $batchTime;

    /**
     * @var JobRepository
     */
    private $jobRepository;

    public function __construct(int $batchSize, int $batchTime)
    {
        $this->batchSize = $batchSize;
        $this->batchTime = $batchTime;
        $this->jobRepository = new JobRepository();
    }

    /**
     * Accept a job and assign a micro batch ID
     * @param Job $job
     *
     */
    public function acceptJob(Job $job)
    {
        $mostRecentBatchId = $this->jobRepository->getLastBatchId($job->id);

        if ($mostRecentBatchId === 0) {
            $assignedBatchNumber = 1;
        } else {
            $jobCount = $this->jobRepository->getNumberOfJobsPerBatch($mostRecentBatchId);
            $jobTime = $this->jobRepository->getEarliestJobTime($mostRecentBatchId);
            $maxAllowedTime = $jobTime + $this->batchTime;

            if ($jobCount < $this->batchSize && $job->timeStamp < $maxAllowedTime) {
                $assignedBatchNumber = $mostRecentBatchId;
            } else {
                $assignedBatchNumber = $mostRecentBatchId + 1;
            }
        }

        $job->batchId = $assignedBatchNumber;
        $job->status = 'accepted';
        $this->jobRepository->saveJob($job);
    }


}
