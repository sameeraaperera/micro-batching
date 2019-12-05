<?php

require_once '../bootstrap.php';

$jobFactory = new JobFactory();
// passing random string as metadata, this could be JSON data
$metadata = uniqid('random_', false);
$job = $jobFactory->createJobFromMetadata($metadata);

$batchSize = 3;
$batchTime = 3; // seconds
$microBatcher = new MicroBatcher($batchSize, $batchTime);
$microBatcher->acceptJob($job);

pr($job);

function pr($obj){
    echo  '<pre>';
    print_r($obj);
    echo  '</pre>';
}

