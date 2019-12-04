<?php

declare(strict_types=1);

class JobFactory
{
    /**
     * @param string $metadata
     *
     * @return Job
     */
    public function createJobFromMetadata(string $metadata): Job
    {
        $job = new Job($metadata);

        $jobRepository = new JobRepository();

        $jobRepository->createJob($job);

        return $job;
    }
}
