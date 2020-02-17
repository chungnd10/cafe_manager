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

    public function getAll()
    {
        $tables = $this->_model->latest('id')->get();
        return $tables;
    }
}
