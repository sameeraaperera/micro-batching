<?php

declare(strict_types=1);

final class JobFactory
{
    /**
     * @param string $metadata
     *
     * @return Job
     */
    public function createJobFromMetadata(string $metadata): Job
    {
        $job = new Job($metadata);
        $job->timeStamp = time();
        $job->batchId = 0;
        $job->status = 'pending';

        $jobRepository = new JobRepository();
        $job->id = $jobRepository->insertJob($job);

        return $job;
    }

    /**
     * @param string $metadata
     *
     * @return Job
     */
    public function createFromDataBaseRow(array $result): Job
    {
        $job = new Job($result['metadata']);
        $job->id = $result['id'];
        $job->status = $result['status'];
        $job->batchId = $result['batch_id'];
        $job->timeStamp = $result['timestamp'];

        return $job;
    }
}
