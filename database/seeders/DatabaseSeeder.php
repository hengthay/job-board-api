<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $users = [
            [
                'name' => 'admin',
                'email' => 'admin@gmail.com',
                'role' => 'admin',
                'password' => Hash::make(env('ADMIN_PASS')),
            ],
            [
                'name' => 'employer',
                'email' => 'employer@gmail.com',
                'role' => 'employer',
                'password' => Hash::make(env('EMPLOYER_PASS')),
            ],
            [
                'name' => 'test',
                'email' => 'test@gmail.com',
                'role' => 'user',
                'password' => Hash::make(env('TEST_PASS')),
            ]
        ];

        foreach($users as $key => $value) {
            User::factory()->create($value);
        }
    }
}
