<?php

declare(strict_types=1);

class JobRepository
{
    /**
     * @var SQLite3
     */
    private $db;

    public function __construct()
    {
        $this->db = new SQLite3('../batch_queue.db');
    }

    /**
     * Insert new job into Table
     *
     * @param Job $job
     */
    public function createJob(Job $job): void
    {
        $stm = $this->db->prepare('INSERT INTO jobs(metadata,timestamp) VALUES (:metadata,:timestamp)');
        $stm->bindValue(':metadata', $job->getMetadata(), SQLITE3_TEXT);
        $stm->bindValue(':timestamp', $job->getTimeStamp(), SQLITE3_INTEGER);
        $stm->execute();
    }
}
