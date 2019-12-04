<?php

declare(strict_types=1);

class Job
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $metadata;

    /**
     * @var string
     */
    private $status;

    /**
     * @var int
     */
    private $timeStamp;

    /**
     * Job constructor.
     *
     * @param string $metadata
     */
    public function __construct(string $metadata)
    {
        $this->metadata = $metadata;
        $this->timeStamp = time();
    }

    /**
     * Reteive stored metadata for a job
     *
     * @return string
     */
    public function getMetadata(): string
    {
        return  $this->metadata;
    }

    /**
     *
     * @return string
     */
    public function getStatus(): string
    {
        return  $this->status;
    }

    /**
     * @return int
     */
    public function getTimeStamp(): int
    {
        return  $this->timeStamp;
    }
}
