<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'view-table',
                'title' => 'Xem bàn'
            ],
            [
                'name' => 'create-table',
                'title' => 'Thêm bàn'
            ],
            [
                'name' => 'update-table',
                'title' => 'Cập nhật bàn'
            ],
            [
                'name' => 'delete-table',
                'title' => 'Xóa bàn'
            ],
            [
                'name' => 'view-category',
                'title' => 'Xem danh mục sản phẩm'
            ],
            [
                'name' => 'create-category',
                'title' => 'Thêm danh mục sản phẩm'
            ],
            [
                'name' => 'update-category',
                'title' => 'Cập nhật danh mục sản phẩm'
            ],
            [
                'name' => 'delete-category',
                'title' => 'Xóa danh mục sản phẩm'
            ],
            [
                'name' => 'view-product',
                'title' => 'Xem sản phẩm'
            ],
            [
                'name' => 'create-product',
                'title' => 'Thêm sản phẩm'
            ],
            [
                'name' => 'update-product',
                'title' => 'Cập nhật sản phẩm'
            ],
            [
                'name' => 'delete-product',
                'title' => 'Xóa sản phẩm'
            ],
            [
                'name' => 'view-user',
                'title' => 'Xem người dùng'
            ],
            [
                'name' => 'create-user',
                'title' => 'Thêm người dùng'
            ],
            [
                'name' => 'update-user',
                'title' => 'Cập nhật người dùng'
            ],
            [
                'name' => 'delete-user',
                'title' => 'Xóa người dùng'
            ],
            [
                'name' => 'view-order',
                'title' => 'Xem order'
            ],
            [
                'name' => 'create-order',
                'title' => 'Thêm order'
            ],
            [
                'name' => 'update-order',
                'title' => 'Cập nhật order'
            ],
            [
                'name' => 'delete-order',
                'title' => 'Xóa order'
            ],
            [
                'name' => 'view-bill',
                'title' => 'Xem hóa đơn'
            ],
            [
                'name' => 'create-bill',
                'title' => 'Thêm hóa đơn'
            ],
            [
                'name' => 'update-bill',
                'title' => 'Cập nhật hóa đơn'
            ]
        ];
        DB::table('permissions')->insert($permissions);
    }
}
