<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'description' => 'Full access user who can manage all aspects of the application.'
            ],
            [
                'name' => 'user',
                'description' => 'Regular registered user with access to standard features.'
            ],
            [
                'name' => 'moderator',
                'description' => ' User responsible for overseeing user-generated content and community interactions.'
            ],
            [
                'name' => 'guest',
                'description' => 'Unauthenticated visitor with limited access.'
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['name' => $role['name']], $role);
        }
    }
}
