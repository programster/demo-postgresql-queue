<?php

/*
 * Create the tasks table to hold the tasks to execute (the queue)
 */

class Init implements \Programster\PgsqlMigrations\MigrationInterface
{
    public function up($connectionResource): void
    {
        $query =
            "CREATE TABLE tasks (
                id uuid NOT NULL,
                payload jsonb NOT NULL,
                created_at int NOT NULL,
                PRIMARY KEY (id)
            );";

        pg_query($connectionResource, $query);

        $indexQuery = "CREATE INDEX on tasks (\"created_at\")";
        pg_query($connectionResource, $indexQuery);
    }

    public function down($connectionResource): void
    {
        $query = "DROP TABLE tasks;";
        pg_query($connectionResource, $query);
    }
}