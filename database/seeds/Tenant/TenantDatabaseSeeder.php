<?php

namespace Database\Seeds\Tenant;

use Illuminate\Database\Seeder;

class TenantDatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(\TenantPermissionsSeeder::class);
    }
}
