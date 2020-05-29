<?php


use Illuminate\Database\Seeder;
use App\Models\Tenant\Permission;

class TenantPermissionsSeeder extends Seeder
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

        foreach ($tenantPermissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'tenant']);
        }
    }
}
