<?php

use \Programster\PgsqlObjects\AbstractTable;


class TaskTable extends AbstractTable
{
    public function getObjectClassName() : string
    {
        return __NAMESPACE__ . '\TaskRecord';
    }


    public function getTableName() : string
    {
        return 'tasks';
    }


    public function validateInputs(array $data) : array
    {
        return $data;
    }


    public function getFieldsThatAllowNull() : array
    {
        return array();
    }


    public function getFieldsThatHaveDefaults() : array
    {
        return array();
    }

    public function getDb(): \Programster\PgsqlObjects\PgSqlConnection
    {
        return SiteSpecific::getDb();
    }
}
