<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = [
            [
                'name' => 'Cà phê'
            ],
            [
                'name' => 'Trà sữa'
            ],
            [
                'name' => 'Nước ép'
            ],
            [
                'name' => 'Sinh tố'
            ],
            [
                'name' => 'Khác'
            ]
        ];
        DB::table('categories')->insert($category);
    }
}
