<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Example_work;
use App\Models\MenuNav;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory()->create(
        //     [
        //         'fio' => fake()->name(),
        //         'role' => 'user',
        //         'email' => fake()->unique()->safeEmail(),
        //         'email_verified_at' => now(),
        //         'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //         'remember_token' => Str::random(10),
        //     ]
        // );
        // User::factory()->create(
        //     [
        //         'fio' => 'admin',
        //         'role' => 'admin',
        //         'email' => 'admin@mail.com',
        //         'email_verified_at' => now(),
        //         'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //         'remember_token' => Str::random(10),
        //     ]
        // );

        Example_work::factory(10)->create();
        MenuNav::factory()->create(
            [
                'name' => 'works',
                'link' => '/works',
                'role' => 'guest',
                'active' => true,
                'sort' => 500,
            ]
        );
        MenuNav::factory()->create(
            [
                'name' => 'workers',
                'link' => '/workers',
                'role' => 'user',
                'active' => false,
                'sort' => 490
            ]
        );
        MenuNav::factory()->create(
            [
                'name' => 'admin',
                'link' => '/admin',
                'role' => 'admin',
                'active' => true,
                'sort' => 400,
            ]
        );

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
