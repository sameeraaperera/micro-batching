# Micro Batcher

This project aims to use a micro batching library to batch incoming processes into "micro batches" to ease
with processing. The actual processor is out of scope of this solution. All incoming jobs are stored in a queue
and assigned a "micro batch id" when the micro batch is full it is sent for processing. The two parameters
that defined a micro batch(max elements and time between first and last job) can be configured by passing
them as constructor parameters to the library. 

## Getting Started

This project needs a web server with php support. If you are running a new version of PHP you can uset
 the built-in webserver.
 
### Requirements

* php 7 or above


### Running the Server

Place the copy of the project somewhere in your local dev environment. Navigate to the root folder and 
start PHP web server. composer is used to download PHPUnit as PHP does not ship with a testing library.

```
$ cd ~/Sites/micro-batching
$ composer install
$ php -S localhost:8001
```

There are 3 helper apis added to this project 

1. View jobs in queue: http://localhost:8001/api/print_queue.php
2. Add job to the queue: http://localhost:8001/api/add_job.php
3. Clear the queue: http://localhost:8001/api/clear_queue.php

## Running the tests

To run the tests navigate to the root directory and then run
```
$ cd ~/Sites/micro-batching 
$ vendor/bin/phpunit tests/
```

##Notes
* The solution uses a sqllite table to get around PHPs stateless problem
* The class that handles the micro batching can be found in src/MicroBatcher.php
* I left job repository untested as it is not part of the batching library and also normally
we would used an ORM to handle the crud operations for us.
* Given more time I would have mocked and dependency injected the JobReposiory during the tests so that
it doesnt hit a real database during unit tests.
