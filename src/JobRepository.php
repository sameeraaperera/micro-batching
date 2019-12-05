<?php

declare(strict_types=1);

final class JobRepository
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
    public function insertJob(Job $job): int
    {
        $stm = $this->db->prepare('INSERT INTO jobs(metadata,timestamp) VALUES (:metadata,:timestamp)');
        $stm->bindValue(':metadata', $job->metadata, SQLITE3_TEXT);
        $stm->bindValue(':timestamp', $job->timeStamp, SQLITE3_INTEGER);
        $stm->execute();

        return $this->db->lastInsertRowID();
    }

    /**
     * @return array
     */
    public function fetchAllPendingJobs(): array
    {
        $res = $this->db->query("SELECT * FROM jobs WHERE status='pending' ORDER BY timestamp");
        $results = [];
        $jobFactory = new JobFactory();
        while ($row = $res->fetchArray()) {
            $results[] = $jobFactory->createFromDataBaseRow($row);
        }

        return $results;
    }

    public function getLastBatchId(int $jobId): int
    {
        return $this->db->querySingle("SELECT batch_id FROM jobs WHERE id!=".$jobId." ORDER BY timestamp DESC LIMIT 1") ?? 0;
    }

    public function saveJob(Job $job)
    {
        $stm = $this->db->prepare('UPDATE jobs SET status=:status,batch_id=:batch_id WHERE id=:id');
        $stm->bindValue(':status', $job->status, SQLITE3_TEXT);
        $stm->bindValue(':batch_id', $job->batchId, SQLITE3_INTEGER);
        $stm->bindValue(':id', $job->id, SQLITE3_INTEGER);
        $stm->execute();
    }

    public function getNumberOfJobsPerBatch(int $batchId)
    {
        return $this->db->querySingle("select count(*) from jobs where batch_id='".$batchId."'");
    }

    public function getEarliestJobTime(int $batchId)
    {
        return $this->db->querySingle("select timestamp from jobs where batch_id='".$batchId."' ORDER BY timestamp LIMIT 1");
    }

}
