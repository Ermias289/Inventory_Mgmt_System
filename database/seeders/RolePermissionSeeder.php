<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // Products
            'products.view',
            'products.create',
            'products.update',
            'products.delete',

            // Categories
            'categories.view',
            'categories.create',
            'categories.update',
            'categories.delete',

            //Suppliers
            'suppliers.view',
            'suppliers.create',
            'suppliers.update',
            'suppliers.delete',

            // Stock
            'stock.view',
            'stock.create',
            'stock.update',
            'stock.remove',

            //Reports
            'reports.view',
            
            //Users
            'users.view',
            'users.create',
            'users.update',
            'users.delete',
        ];

        foreach($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission, 
                'guard_name' => 'api',
                ]);
        }


        $admin = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'api',
        ]);

        $manager = Role::firstOrCreate([
            'name' => 'Manager',
            'guard_name' => 'api',
        ]);

        $employee = Role::firstOrCreate([
            'name' => 'Employee',
            'guard_name' => 'api',
        ]);

        $admin->givePermissionTo(Permission::all());
        $manager->givePermissionTo([
            'products.view',
            'products.create',
            'products.update',
            'products.delete',   

            'categories.view',
            'categories.create',
            'categories.update',
            'suppliers.view',
            'suppliers.create',
            'suppliers.update',
            'stock.view',
            'stock.create',
            'stock.update',
            'reports.view',
        ]);

        $employee->givePermissionTo([
            'products.view',
            'categories.view',
            'suppliers.view',
            'stock.view',
        ]);

    }
}
