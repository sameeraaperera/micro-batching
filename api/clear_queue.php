<?php

require_once '../bootstrap.php';

$db = new SQLite3($GLOBALS['_DB_PATH']);
$res = $db->exec('delete FROM jobs');

print('Queue cleared');
