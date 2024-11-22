<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $admin = User::create([
            'name' => 'administrador',
            'email' => 'admin@example.com',
            'password' => Hash::make('12345678'),
        ]);
        $admin->assignRole('administrador');

        $director = User::create([
            'name' => 'director',
            'email' => 'director@example.com',
            'password' => Hash::make('12345678'),
        ]);
        $director->assignRole('director');

        $profesor = User::create([
            'name' => 'profesor',
            'email' => 'profesor@example.com',
            'password' => Hash::make('12345678'),
        ]);
        $profesor->assignRole('profesor');
    }
}
