<?php

/*
 *
 */

class QueueService
{
    private bool $m_transactionInProgress = false;
    private Programster\PgsqlObjects\PgSqlConnection $m_db;


    public function __construct()
    {
        $this->m_db = Programster\PgsqlObjects\PgSqlConnection::create(
            host: DB_HOST,
            dbName: DB_NAME,
            user: DB_USER,
            password: DB_PASSWORD,
            forceNew: true // need to leave transaction outstanding, so want to use own dedicated connection.
        );
    }


    public function fetchTasks(int $maxTasks=1)
    {
        if ($this->m_transactionInProgress)
        {
            throw new Exception("Cannot fetch tasks whilst another set are waiting to be deleted or rolled back.");
        }

        $query =
            "BEGIN;
            DELETE FROM
                tasks
            USING (
                SELECT * FROM tasks ORDER BY created_at ASC LIMIT {$maxTasks} FOR UPDATE SKIP LOCKED
            ) q
            WHERE q.id = tasks.id RETURNING tasks.*;";

        $result = Safe\pg_query($this->m_db->getResource(), $query);

        if ($result === false)
        {
            throw new Exception("Failed to fetch tasks due to error.");
        }

        $rows = pg_fetch_all($result);
        $tasks = [];
        $fieldInfoMap = pg_meta_data($this->m_db->getResource(), "tasks");

        foreach ($rows as $row)
        {
            $tasks[] = TaskRecord::createFromDatabaseRow($row, $fieldInfoMap);
        }

        return $tasks;
    }


    public function markTasksCompleted()
    {
        $result = Safe\pg_query($this->m_db->getResource(), "COMMIT;");
    }


    public function rollbackTasks()
    {
        $result = Safe\pg_query($this->m_db->getResource(), "ROLLBACK;");
    }
}