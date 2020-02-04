<?php

use Illuminate\Database\Seeder;

class TablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tables = [];
        for ($i = 1; $i <= 30; $i++) {
            $item = [
                'name' => 'Bàn số ' . $i,
                'number_of_seats' => 4,
                'table_status_id' => 1
            ];

            $tables[] = $item;
        }

        DB::table('tables')->insert($tables);
    }
}
