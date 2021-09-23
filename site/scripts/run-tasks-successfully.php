<?php

/*
 * This script is to simulate fetching a task and it running successfully, so we mark it as completed so it gets
 * removed from the queue.
 * You should also see what happens if you quit-out before the script successfully finishes. E.g. run ctrl-c whilst
 * executing. You shoul see that the tasks are left in the queu for another worker to work on them. This might happen
 * if your worker runs out of memory etc.
 */

require_once(__DIR__ . '/../bootstrap.php');
$queue = new QueueService();
$tasks = $queue->fetchTasks(maxTasks: 1);

foreach ($tasks as $task)
{
    /* @var $task TaskRecord */
    $payload = json_decode($task->getPayload(), true);
    eval($payload['code']);
}

$queue->markTasksCompleted();