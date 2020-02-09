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

    public function datatables()
    {
        $products = Product::join('categories', 'categories.id', '=', 'products.category_id')
            ->select(
                'products.id',
                'products.name as product_name',
                'avatar',
                'price',
                'description',
                'categories.name as category_name'
            )
            ->orderBy('products.id', 'desc')
            ->get();

        return $products;

    }
}
