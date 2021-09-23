<?php

/*
 * This script is to simulate fetching a task and something going wrong, so we leave the tasks in the queu
 * such that they can be grabbed again by another worker.
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

sleep(3);

//$queue->rollbackTasks();
$queue->markTasksCompleted();