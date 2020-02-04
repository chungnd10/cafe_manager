<?php

use Illuminate\Database\Seeder;

class TableStatusTableSeeder extends Seeder
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
                'name' => 'Trống'
            ],
            [
                'name' => 'Đã sử dụng'
            ]
        ];
        DB::table('table_status')->insert($status);
    }
}
