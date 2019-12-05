<?php

require_once '../bootstrap.php';

$jobFactory = new JobFactory();
$db = new SQLite3($GLOBALS['_DB_PATH']);
$res = $db->query('SELECT * FROM jobs');
//$res = $db->exec('delete FROM jobs');

$output = [];
while ($row = $res->fetchArray()) {
    $job = $jobFactory->createFromDataBaseRow($row);
    $output[] = (array) $job;
}

print(json_encode($output));
