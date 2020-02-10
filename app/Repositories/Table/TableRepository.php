<?php
namespace App\Repositories\Table;

use App\Models\Table;
use App\Repositories\EloquentRepository;


class TableRepository extends EloquentRepository
{
    public function getModel()
    {
        return Table::class;
    }

    public function datatables()
    {
        $tables = Table::join('table_status', 'table_status.id', '=', 'tables.table_status_id')
            ->select(
                'tables.id',
                'tables.name as table_name',
                'number_of_seats',
                'table_status.name as status_name'
            )
            ->orderBy('tables.id', 'desc')
            ->get();
        return $tables;
    }
}
