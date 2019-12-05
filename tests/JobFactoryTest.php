<?php

declare(strict_types=1);

require_once 'bootstrap.php';

use PHPUnit\Framework\TestCase;

final class JobFactoryTest extends TestCase
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

    public function testCanCreateJob(): void
    {
        $metadata = 'some data';
        $jobFactory = new JobFactory();
        $job = $jobFactory->createJobFromMetadata($metadata);

        $this->assertInstanceOf(Job::class, $job);

        $this->assertSame(time(), $job->timeStamp);
        $this->assertIsInt($job->id);
        $this->assertSame($metadata, $job->metadata);
        $this->assertSame(0, $job->batchId);
        $this->assertSame('pending', $job->status);
    }
}
