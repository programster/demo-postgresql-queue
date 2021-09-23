<?php

/*
 * A script to run databse migrations.
 */

require_once(__DIR__ . '/../bootstrap.php');

$migrationManager = new Programster\PgsqlMigrations\MigrationManager(
    __DIR__ . '/../migrations',
    SiteSpecific::getDb()->getResource()
);

$migrationManager->migrate();