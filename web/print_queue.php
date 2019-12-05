<?php

require_once '../bootstrap.php';

$jobFactory = new JobFactory();
$db = new SQLite3('../batch_queue.db');
$res = $db->query('SELECT * FROM jobs');
while ($row = $res->fetchArray()) {
    $job = $jobFactory->createFromDataBaseRow($row);
    pr($job);
}

function pr($obj){
    echo  '<pre>';
    print_r($obj);
    echo  '</pre>';
}

