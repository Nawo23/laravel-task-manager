<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Task;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create a demo user
        $user = User::create([
            'name'     => 'Demo User',
            'email'    => 'demo@example.com',
            'password' => Hash::make('password'),
        ]);

        // Create some demo tasks
        $tasks = [
            ['title' => 'Set up development environment', 'description' => 'Install PHP, Composer, and Laravel.', 'status' => 'done'],
            ['title' => 'Review project requirements', 'description' => 'Go through all the assessment requirements carefully.', 'status' => 'done'],
            ['title' => 'Build authentication system', 'description' => 'Implement registration and login using Laravel Sanctum.', 'status' => 'done'],
            ['title' => 'Create task CRUD endpoints', 'description' => 'Build create, read, update, and delete functionality for tasks.', 'status' => 'pending'],
            ['title' => 'Write unit tests', 'description' => 'Test all routes and models to ensure correct behavior.', 'status' => 'pending'],
            ['title' => 'Deploy to production', 'description' => 'Set up server and deploy the application.', 'status' => 'pending'],
        ];

        foreach ($tasks as $task) {
            $user->tasks()->create($task);
        }
    }
}
