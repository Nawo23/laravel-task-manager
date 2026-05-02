# TaskManager — Laravel Assessment Project

A task management application built with **Laravel 10**, **Blade**, and **Laravel Sanctum**.

## Features
- User registration and login
- Create, view, update, delete tasks
- Task status: pending / done
- One-click status toggle
- Filter tasks by status
- Users can only access their own tasks

## Requirements
- PHP >= 8.1
- Composer
- MySQL

## Setup Instructions

### 1. Clone the repository
git clone https://github.com/YOUR_USERNAME/laravel-task-manager.git
cd laravel-task-manager

### 2. Install dependencies
composer install

### 3. Configure environment
copy .env.example .env
php artisan key:generate

### 4. Update .env with your database credentials
DB_DATABASE=task_manager
DB_USERNAME=root
DB_PASSWORD=

### 5. Create the database
CREATE DATABASE task_manager;

### 6. Run migrations and seed
php artisan migrate --seed

### 7. Start the server
php artisan serve

Visit http://localhost:8000

## Demo Account
Email:    demo@example.com
Password: password