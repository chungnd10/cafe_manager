<?php

use Illuminate\Database\Seeder;

class RolePermissionTableSeeder extends Seeder
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
                'role_id' => 2,
                'permission_id' => 17
            ],
            [
                'role_id' => 2,
                'permission_id' => 18
            ],
            [
                'role_id' => 2,
                'permission_id' => 19
            ],
            [
                'role_id' => 2,
                'permission_id' => 20
            ],
            [
                'role_id' => 3,
                'permission_id' => 17
            ],
            [
                'role_id' => 3,
                'permission_id' => 18
            ],
            [
                'role_id' => 3,
                'permission_id' => 19
            ],
            [
                'role_id' => 3,
                'permission_id' => 20
            ],
            [
                'role_id' => 4,
                'permission_id' => 21
            ],
            [
                'role_id' => 4,
                'permission_id' => 22
            ],
            [
                'role_id' => 4,
                'permission_id' => 23
            ]
        ];
        DB::table('role_permission')->insert($permissions);
    }
}
