<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAdminUser();
        $this->createVisitorUser();
    }

    private function createAdminUser()
    {
        $adminUser = User::factory()->create([
            'first_name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('secret'),
            'mobile' => '01234567891',
        ]);

        $adminUser->assignRole('admin');
    }

    private function createVisitorUser()
    {
        $visitorUser = User::factory()->create([
            'first_name' => 'Visitor',
            'email' => 'visitor@example.com',
            'mobile' => '01000000000',
        ]);

        $visitorUser->assignRole('visitor');
    }
}
