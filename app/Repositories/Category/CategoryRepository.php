<?php
namespace App\Repositories\Category;

use App\Repositories\EloquentRepository;
use App\Models\Category;

class CategoryRepository extends EloquentRepository
{

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return Category::class;
    }


}
