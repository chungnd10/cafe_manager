<?php
namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\EloquentRepository;

class ProductRepository extends EloquentRepository
{

    /**
     * Get model
     * @return string
     */
    public function getModel()
    {
       return Product::class;
    }

    public function getAll()
    {
        $products = $this->_model->with('category')->latest('id')->get();

        return $products;

    }
}
