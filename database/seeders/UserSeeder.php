<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Owner',
            'email' => 'owner@kunjungansales.test',
            'password' => bcrypt('password'),
            'role' => 'owner',
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@kunjungansales.test',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Sales Satu',
            'email' => 'sales@kunjungansales.test',
            'password' => bcrypt('password'),
            'role' => 'sales',
        ]);
    }
}
