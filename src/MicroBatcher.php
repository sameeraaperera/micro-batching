<?php

declare(strict_types=1);

require_once 'JobResultInterface.php';
require_once 'JobBase.php';

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
     * @param JobBase $job
     *
     * @return JobResultInterface
     */
    public function acceptJob(JobBase $job): JobResultInterface
    {
        // save job
    }
}
