<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once(__DIR__ . '/../bootstrap.php');
$task = TaskRecord::create(['code' => 'print "This task was created at: ' . date('H:i:s', time()) . '" . PHP_EOL; sleep(3);']);
$task->save();