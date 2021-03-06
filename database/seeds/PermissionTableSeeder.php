<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;


class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $permissions = [           
           'task-list',
           'task-create',
           'task-edit',
           'task-delete',           
        ];
   
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}

// $permissions = [
// 'role-list',
// 'role-create',
// 'role-edit',
// 'role-delete',         
// 'user-list',
// 'user-create', 
// 'user-edit',          
// 'user-delete',
// 'orderstatus-list',
// 'orderstatus-create',
// 'orderstatus-edit',
// 'orderstatus-delete',
// 'pricing-list',
// 'pricing-create',
// 'pricing-edit',
// 'pricing-delete',
// 'plan-list',
// 'plan-create',
// 'plan-edit',
// 'plan-delete',
// 'customer-list',
// 'customer-create',
// 'customer-edit',
// 'customer-delete',
// 'order-list',
// 'order-create',
// 'order-edit',
// 'order-delete',  
// 'complaint-list',
// 'complaint-create',
// 'complaint-edit',
// 'complaint-delete',  
// 'dsr-list',
// 'dsr-create',
// 'dsr-edit',
// 'dsr-delete',          
// ];