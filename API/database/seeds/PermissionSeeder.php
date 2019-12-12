<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Role;
        $role->id = 2;
        $role->role = "users";
        $role->save();

        $role = new Role;
        $role->id = 1;
        $role->role = "super_admin";
        $role->save();        

        $permissionGoingTo = $role->permissions();
        for($a = 0; $a < 16; $a++) {           
            $permission = new Permission;
            $permission->feature_id = ($a+1);      
            $permission->active = 1;      
            $permissionGoingTo->save($permission);               
        }
    }
}
