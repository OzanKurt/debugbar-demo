<?php

namespace App\DataTables;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class UsersDataTable extends DataTable
{
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))->setRowId('id');
    }

    public function query(): QueryBuilder
    {
        return User::query();
    }

    public function html(): HtmlBuilder
    {
        $data = [];

        if (request()?->boolean('custom_parsing', false)) {
            $data = [
                'custom_parsing' => true,
            ];
        }

        return $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax('datatable', null, $data)
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
            ]);
    }

    public function getColumns(): array
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('email'),
            Column::make('created_at'),
            Column::make('updated_at'),
        ];
    }

    protected function filename(): string
    {
        return 'Users_'.date('YmdHis');
    }
}
