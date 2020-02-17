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
                'name' => 'view-tables',
                'title' => 'Xem bàn'
            ],
            [
                'name' => 'create-tables',
                'title' => 'Thêm bàn'
            ],
            [
                'name' => 'update-tables',
                'title' => 'Cập nhật bàn'
            ],
            [
                'name' => 'delete-tables',
                'title' => 'Xóa bàn'
            ],
            [
                'name' => 'view-categories',
                'title' => 'Xem danh mục sản phẩm'
            ],
            [
                'name' => 'create-categories',
                'title' => 'Thêm danh mục sản phẩm'
            ],
            [
                'name' => 'update-categories',
                'title' => 'Cập nhật danh mục sản phẩm'
            ],
            [
                'name' => 'delete-categories',
                'title' => 'Xóa danh mục sản phẩm'
            ],
            [
                'name' => 'view-products',
                'title' => 'Xem sản phẩm'
            ],
            [
                'name' => 'create-products',
                'title' => 'Thêm sản phẩm'
            ],
            [
                'name' => 'update-products',
                'title' => 'Cập nhật sản phẩm'
            ],
            [
                'name' => 'delete-products',
                'title' => 'Xóa sản phẩm'
            ],
            [
                'name' => 'view-users',
                'title' => 'Xem người dùng'
            ],
            [
                'name' => 'create-users',
                'title' => 'Thêm người dùng'
            ],
            [
                'name' => 'update-users',
                'title' => 'Cập nhật người dùng'
            ],
            [
                'name' => 'delete-users',
                'title' => 'Xóa người dùng'
            ],
            [
                'name' => 'view-orders',
                'title' => 'Xem order'
            ],
            [
                'name' => 'create-orders',
                'title' => 'Thêm order'
            ],
            [
                'name' => 'update-orders',
                'title' => 'Cập nhật order'
            ],
            [
                'name' => 'delete-orders',
                'title' => 'Xóa order'
            ],
        ];
        DB::table('permissions')->insert($permissions);
    }
}
