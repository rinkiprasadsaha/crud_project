<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class PermissionRoleSeeder extends Seeder
{
    public function run()
    {
 // Define roles
 $superAdminRole = Role::firstOrCreate(['name' => 'super-admin']);
 $adminRole = Role::firstOrCreate(['name' => 'admin']);
 $userRole = Role::firstOrCreate(['name' => 'user']);

 // Define permissions
 $permissions = [
     'view-products',
     'create-products',
     'edit-products',
     'delete-products',
     'view-categories',
     'create-categories',
     'edit-categories',
     'delete-categories',
     'view-users',
     'create-users',
     'edit-users',
     'delete-users',
     'show-products-by-id',
 ];

 foreach ($permissions as $permission) {
     Permission::firstOrCreate(['name' => $permission]);
 }

 // Assign permissions to roles
 $superAdminRole->givePermissionTo(Permission::all());

 $adminRole->givePermissionTo([
     'view-products',
     'create-products',
     'edit-products',
     'delete-products',
     'view-categories',
     'create-categories',
     'edit-categories',
     'delete-categories',
     'view-users',
     'create-users',
     'edit-users',
     'delete-users',
 ]);

 $userRole->givePermissionTo([
     'view-products',
     'create-products',
     'edit-products',
     'delete-products',
     'show-products-by-id',
     'view-categories',
     'create-categories',
     'edit-categories',
     'delete-categories',
 ]);

    }

}
