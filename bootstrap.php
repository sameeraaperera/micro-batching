<?php

require_once 'src/BatchProcessor.php';
require_once 'src/Job.php';
require_once 'src/JobFactory.php';
require_once 'src/JobRepository.php';
require_once 'src/JobResult.php';
require_once 'src/MicroBatcher.php';

$GLOBALS['_DB_PATH'] = '../db/batch_queue.db';
