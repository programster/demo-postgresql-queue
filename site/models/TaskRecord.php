<?php

use \Programster\PgsqlObjects\AbstractTableRowObject;
use \Programster\PgsqlObjects\TableInterface;


class TaskRecord extends AbstractTableRowObject
{
    protected string $m_id;
    protected string $m_payload;
    protected int $m_createdAt;


    public static function create(array|JsonSerializable $payload) : TaskRecord
    {
        $task = new TaskRecord();
        $task->m_id = \Programster\PgsqlObjects\Utils::generateUuid();
        $task->m_payload = Safe\json_encode($payload);
        $task->m_createdAt = time();
        return $task;
    }


    protected function getAccessorFunctions() : array
    {
        return array(
            "id" => function() : string { return $this->m_id; },
            "payload" => function() : string { return $this->m_payload; },
            "created_at" => function() : int { return $this->m_createdAt; },
        );
    }

    protected function getSetFunctions() : array
    {
        return array(
            "id" => function(string $x) { $this->m_id = $x; },
            "payload" => function(string $x) { $this->m_payload = $x; },
            "created_at" => function(int $x) { $this->m_createdAt = $x; },
        );
    }


    public function validateInputs(array $data) : array
    {
        return $data;
    }


    protected function filterInputs(array $data) : array
    {
        return $data;
    }


    public function getTableHandler() : TableInterface
    {
        return TaskTable::getInstance();
    }


    # Accessors
    public function getPayload() : string { return $this->m_payload; }
    public function getCreatedAt() : int { return $this->m_createdAt; }
}


