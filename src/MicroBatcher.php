<?php

declare(strict_types=1);

final class MicroBatcher
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

    /**
     * MicroBatcher constructor.
     *
     * @param int $batchSize
     * @param int $batchTime
     */
    public function __construct(int $batchSize, int $batchTime)
    {
        $this->batchSize = $batchSize;
        $this->batchTime = $batchTime;
        $this->jobRepository = new JobRepository();
    }

    /**
     * Accept a job and assign a micro batch ID
     *
     * @param Job $job
     *
     * @return JobResult
     */
    public function acceptJob(Job $job): JobResult
    {
        $mostRecentBatchId = $this->jobRepository->getLastBatchId($job->id);

        if ($mostRecentBatchId === 0) {
            $assignedBatchId = 1;
        } else {
            $jobCount = $this->jobRepository->getNumberOfJobsPerBatch($mostRecentBatchId);
            $jobTime = $this->jobRepository->getEarliestJobTime($mostRecentBatchId);
            $maxAllowedTime = $jobTime + $this->batchTime;

            // Use the current micro batch only if the size and time conditions are met
            if ($jobCount < $this->batchSize && $job->timeStamp < $maxAllowedTime) {
                $assignedBatchId = $mostRecentBatchId;
            } else {
                $assignedBatchId = $mostRecentBatchId + 1;
                //When the batch id is incremented then the previous micro batch is ready for processing
                $this->processMicroBatch($mostRecentBatchId);
            }
        }

        $job->batchId = $assignedBatchId;
        $job->status = 'accepted';
        $this->jobRepository->saveJob($job);

        return new JobResult($assignedBatchId);
    }

    /**
     * Process a micro batch using an external service
     *
     * @param $batchId
     */
    public function processMicroBatch(int $batchId): void
    {
        $processor = new BatchProcessor();
        $processor->process($batchId);
    }
}
