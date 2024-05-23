<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create roles
        $super_adminRole = Role::create(['name' => 'super-admin']);
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Create permissions
         Permission::create(['name' => 'view-users']);
         Permission::create(['name' => 'create-users']);
         Permission::create(['name' => 'edit-users']);
         Permission::create(['name' => 'delete-users']);

         Permission::create(['name' => 'view-categorys']);
         Permission::create(['name' => 'create-categorys']);
         Permission::create(['name' => 'edit-categorys']);
         Permission::create(['name' => 'delete-categorys']);


         // Create permissions
         Permission::create(['name' => 'view-products']);
         Permission::create(['name' => 'create-products']);
         Permission::create(['name' => 'edit-products']);
         Permission::create(['name' => 'delete-products']);
         Permission::create(['name' => 'show-products-by-id']);
         Permission::create(['name' => 'restore-products']);

        // Assign permissions to roles
         $super_adminRole->givePermissionTo(Permission::all());

        // permission for admin
        $adminRole->givePermissionTo('view-products');
        $adminRole->givePermissionTo('create-products');
        $adminRole->givePermissionTo('edit-products');
        $adminRole->givePermissionTo('delete-products');

        $adminRole->givePermissionTo('view-categorys');
        $adminRole->givePermissionTo('create-categorys');
        $adminRole->givePermissionTo('edit-categorys');
        $adminRole->givePermissionTo('delete-categorys');

        $adminRole->givePermissionTo('view-users');
        $adminRole->givePermissionTo('create-users');
        $adminRole->givePermissionTo('edit-users');
        $adminRole->givePermissionTo('delete-users');

        // permission for user
        $userRole->givePermissionTo('view-products');
        $userRole->givePermissionTo('create-products');
        $userRole->givePermissionTo('edit-products');
        $userRole->givePermissionTo('delete-products');
        $userRole->givePermissionTo('show-products-by-id');

         $userRole->givePermissionTo('view-categorys');
         $userRole->givePermissionTo('create-categorys');
         $userRole->givePermissionTo('edit-categorys');
         $userRole->givePermissionTo('delete-categorys');

         



    }

}


