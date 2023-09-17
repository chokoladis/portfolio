<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Example_work;
use App\Models\MenuNav;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Example_work::factory(10)->create();
        MenuNav::factory()->create(
            [
                'name' => 'works',
                'link' => '/works',
                'role' => 'user',
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
