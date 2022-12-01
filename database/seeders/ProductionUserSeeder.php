<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductionUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createRootUser();
        $this->createAdminUser();
        $this->createVisitorUser();
    }

    private function createRootUser()
    {
        $rootUser = User::factory()->create([
            'email' => 'eLaundry@root.com',
            'is_active' => true,
            'password' => Hash::make('/yf(?CvqvlyM8?X&dc,x')
        ]);

        $rootUser->assignRole('root');
    }

    private function createAdminUser()
    {
        $adminUser = User::factory()->create([
            'email' => 'shofikul@example.com',
            'is_active' => true,
            'password' => Hash::make('elaundry@1234')
        ]);

        $adminUser->assignRole('admin');
    }

    private function createVisitorUser()
    {
        $visitorUser = User::factory()->create([
            'first_name' => 'Visitor',
            'email' => 'eLaundry@visitor.com',
            'password' => Hash::make('Visitor@12345'),
            'is_active' => true,
        ]);

        $visitorUser->assignRole('visitor');
    }
}
