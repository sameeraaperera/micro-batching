<?php

declare(strict_types=1);

require_once 'bootstrap.php';

use PHPUnit\Framework\TestCase;

final class MicroBatcherTest extends TestCase
{
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        $GLOBALS['_DB_PATH'] = 'db/batch_queue_test.db';

        parent::__construct($name, $data, $dataName);
    }

    public function tearDown(): void
    {
        $db = new SQLite3($GLOBALS['_DB_PATH']);
        $db->exec('delete FROM jobs');

        parent::tearDown();
    }

    public function testCanAcceptJob(): void
    {
        $microBatcher = new MicroBatcher(1, 1);
        $job = (new JobFactory())->createJobFromMetadata('sample');

        $result = $microBatcher->acceptJob($job);

        $this->assertInstanceOf(JobResult::class, $result);
        $this->assertSame(1, $job->batchId);
    }

    public function testDoesIncrementBatchIdWhenBatchSizeReached(): void
    {
        $microBatcher = new MicroBatcher(2, 1);
        $job1 = (new JobFactory())->createJobFromMetadata('sample');
        $job2 = (new JobFactory())->createJobFromMetadata('sample');
        $job3 = (new JobFactory())->createJobFromMetadata('sample');

        $microBatcher->acceptJob($job1);
        $microBatcher->acceptJob($job2);
        $microBatcher->acceptJob($job3);

        $this->assertSame(1, $job1->batchId);
        $this->assertSame(1, $job2->batchId);
        $this->assertSame(2, $job3->batchId);
    }

    public function testDoesIncrementBatchIdWhenTimeLimitReached(): void
    {
        $microBatcher = new MicroBatcher(5, 2);
        $job1 = (new JobFactory())->createJobFromMetadata('sample');
        $job2 = (new JobFactory())->createJobFromMetadata('sample');
        $job3 = (new JobFactory())->createJobFromMetadata('sample');
        //set the incoming jobs time 3 seconds later than the 1st job
        $job3->timeStamp = $job3->timeStamp + 3;

        $microBatcher->acceptJob($job1);
        $microBatcher->acceptJob($job2);
        $microBatcher->acceptJob($job3);

        $this->assertSame(1, $job1->batchId);
        $this->assertSame(1, $job2->batchId);
        $this->assertSame(2, $job3->batchId);
    }
}
