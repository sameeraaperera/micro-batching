<?php

declare(strict_types=1);

class JobResult
{
    /**
     * @var int
     */
    public $batchId;

    /**
     * JobResult constructor.
     *
     * @param int $batchId
     */
    public function __construct(int $batchId)
    {
        $this->batchId = $batchId;
    }
}
