<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = [];
        for ($i = 1; $i <= 30; $i++) {
            $item = [
                'name' => 'Sản phẩm '. $i,
                'avatar' => 'product-default.jpg',
                'price' => 35000,
                'description' => 'Đây là mô tả',
                'category_id' => random_int(1, 5)
            ];

            $products[] = $item;
        }

        DB::table('products')->insert($products);
    }
}
