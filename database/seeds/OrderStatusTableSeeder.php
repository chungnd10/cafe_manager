<?php

use Illuminate\Database\Seeder;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $status = [
            [
                'name' => 'Chưa xử lý'
            ],
            [
                'name' => 'Đang xử lý'
            ],
            [
                'name' => 'Đã hoàn thành'
            ]
        ];
        DB::table('order_status')->insert($status);
    }
}
