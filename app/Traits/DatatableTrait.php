<?php

namespace App\Traits;

use Yajra\DataTables\Facades\DataTables;

trait DataTableTrait
{
    protected function createDataTable($query, $columns, $actionsCallback = null)
    {
        $dataTable = DataTables::of($query);

        if ($actionsCallback) {
            $dataTable->addColumn('action', $actionsCallback)->rawColumns(['action']);
        }

        foreach ($columns as $column) {
            if (is_array($column)) {
                $dataTable->addColumn($column['data'], function ($row) use ($column) {
                    return $row->{$column['field']};
                });
            }
        }

        return $dataTable->make(true);
    }
}