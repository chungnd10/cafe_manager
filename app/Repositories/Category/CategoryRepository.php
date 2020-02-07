<?php
namespace App\Repositories\Category;

use App\Repositories\EloquentRepository;

class CategoryRepository extends EloquentRepository
{

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return \App\Models\Category::class;
    }


}
