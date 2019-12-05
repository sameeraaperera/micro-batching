<?php

require_once '../bootstrap.php';

$db = new SQLite3('../batch_queue.db');
$res = $db->exec('delete FROM jobs');

print('Queue cleared');
