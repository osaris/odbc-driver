<?php

namespace Ccovey\ODBCDriver\Processors;

use Illuminate\Database\Query\Processors\Processor;
use Illuminate\Database\Query\Builder;

class SQLAnywhere extends Processor
{
    /**
     * Process an "insert get ID" query.
     *
     * @param  \Illuminate\Database\Query\Builder  $query
     * @param  string  $sql
     * @param  array   $values
     * @param  string  $sequence
     * @return int
     */
    public function processInsertGetId(Builder $query, $sql, $values, $sequence = null)
    {
      $query->getConnection()->insert($sql, $values);

      $result = $query->getConnection()->getPdo()->query('SELECT @@IDENTITY');

      $id = $result->fetchColumn();

      return is_numeric($id) ? (int) $id : $id;
    }
}
