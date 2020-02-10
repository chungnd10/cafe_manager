<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'name' => 'Super Admin'
            ],
            [
                'name' => 'Quản lý'
            ],
            [
                'name' => 'Nhân viên phục vụ'
            ],
            [
                'name' => 'Nhân viên pha chế'
            ],
            [
                'name' => 'Nhân viên thu ngân'
            ]
        ];
        DB::table('roles')->insert($roles);
    }
}
