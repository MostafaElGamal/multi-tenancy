<?php

use Illuminate\Database\Seeder;
use App\Models\System\Permission;
// use Spatie\Permission\Models\Permission;

class SystemPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $systemPermissions = config('permission.permissions_list')['system'];
        $tenantPermissions = config('permission.permissions_list')['tenant'];
        foreach ($systemPermissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'system']);
        }
        foreach ($tenantPermissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'customer']);
        }
    }
}
