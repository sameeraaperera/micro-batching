<?php

require_once '../bootstrap.php';

$jobFactory = new JobFactory();
$metadata = uniqid('random_', false); // passing random string as metadata, this could be JSON data.
$job = $jobFactory->createJobFromMetadata($metadata);

$batchSize = 3;
$batchTime = 3; // seconds
$microBatcher = new MicroBatcher($batchSize, $batchTime);
$jobResult = $microBatcher->acceptJob($job);

$output = [
    'job' => (array) $job,
    'result' => (array) $jobResult,
];
print(json_encode($output));
