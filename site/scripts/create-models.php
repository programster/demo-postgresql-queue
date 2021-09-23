<?php

/*
 * Generate the models based on the database structure.
 */

require_once(__DIR__ . '/../bootstrap.php');

$generator = new Programster\OrmGenerator\PgSqlGenerator(SiteSpecific::getDb()->getResource(), __DIR__ . '/../models');
$generator->run();