<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use App\Models\System\User;
use App\Models\System\Permission;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::where('guard_name', 'system')->get();
        
        $user =   User::create([
            'name' => 'mustafa el-gaml',
            'email' => 'admin@mail.com',
            'email_verified_at' => now(),
            'password' => 'password', 
            'remember_token' => Str::random(10),
            ]);
        $user->givePermissionTo($permissions);
    }
}
