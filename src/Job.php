<?php

declare(strict_types=1);

class Job
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $metadata;

    /**
     * @var string
     */
    public $status;

    /**
     * @var int
     */
    public $timeStamp;

    /**
     * @var int
     */
    public $batchId;

    /**
     * Job constructor.
     *
     * @param string $metadata
     */
    public function __construct(string $metadata)
    {
        $this->metadata = $metadata;
    }
}
