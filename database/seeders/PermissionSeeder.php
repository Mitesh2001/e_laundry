<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = config('acl.permissions');

        if (empty($permissions) || !is_array($permissions)) {
            return;
        }

        foreach ($permissions as $permission => $value) {
            Permission::findOrCreate($permission, 'web');
        }
    }
}
