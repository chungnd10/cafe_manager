<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(BillsStatusTableSeeder::class);
         $this->call(CategoriesTableSeeder::class);
         $this->call(OrderStatusTableSeeder::class);
         $this->call(PermissionsTableSeeder::class);
         $this->call(ProductsTableSeeder::class);
         $this->call(RolesTableSeeder::class);
         $this->call(RolePermissionTableSeeder::class);
         $this->call(TablesTableSeeder::class);
         $this->call(UsersTableSeeder::class);
    }
}
