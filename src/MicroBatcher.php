<?php

declare(strict_types=1);

class MicroBatcher
{
    /**
     * @var int
     */
    private $batchSize;

    public function __construct(int $batchSize)
    {
        $this->batchSize = $batchSize;
    }

    /**
     * @param Job $job
     *
     */
    public function acceptJob(Job $job)
    {
        // save job
    }
}
