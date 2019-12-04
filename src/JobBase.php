<?php

declare(strict_types=1);

abstract class JobBase
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var array
     */
    private $metadata;

    /**
     * JobBase constructor.
     *
     * @param string $metadata
     */
    public function __construct(array $metadata)
    {
        $this->metadata = $metadata;
    }

    /**
     * Reteive stored metadata for a job
     *
     * @return array
     */
    public function getMetadata(): array
    {
        return  $this->metadata;
    }
}
