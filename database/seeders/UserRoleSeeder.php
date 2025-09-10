<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRoleSeeder extends Seeder
{
    public function run()
    {
        // Formateur
        User::updateOrCreate(
            ['email' => 'formateur@example.com'],
            [
                'name' => 'Formateur Test',
                'password' => Hash::make('password'),
                'role' => 'formateur',
            ]
        );

        // Admin
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin Test',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Apprenant
        User::updateOrCreate(
            ['email' => 'apprenant@example.com'],
            [
                'name' => 'Apprenant Test',
                'password' => Hash::make('password'),
                'role' => 'apprenant',
            ]
        );
    }
}
