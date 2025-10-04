<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create Admin User
        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'), // default password
        ]);

        // Call Other Seeders
        $this->call([
            BlogPostSeeder::class,
            ProductSeeder::class,
            PageSeeder::class,
            FaqSeeder::class,
        ]);
    }
}
