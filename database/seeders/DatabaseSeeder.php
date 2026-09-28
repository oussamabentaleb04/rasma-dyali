<?php

namespace Database\Seeders;

use App\Models\Pattern;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@rasmadyali.com'],
            [
                'name' => 'Admin Rasma Dyali',
                'password' => Hash::make('Admin@12345'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        $oussama = User::updateOrCreate(
            ['email' => 'oussama@rasmadyali.com'],
            [
                'name' => 'Oussama Bentaleb',
                'password' => Hash::make('Password@123'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );

        $amina = User::updateOrCreate(
            ['email' => 'amina@rasmadyali.com'],
            [
                'name' => 'Amina',
                'password' => Hash::make('Password@123'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );

        Pattern::query()->delete();

        Pattern::create([
            'user_id' => $oussama->id,
            'title' => 'Blue Moroccan Star',
            'symmetry_type' => '8-fold',
            'base_shape' => 'star',
            'colors' => ['#1e3a8a', '#ffffff', '#60a5fa'],
            'grid_density' => 8,
            'is_public' => true,
            'is_featured' => true,
            'likes_count' => 12,
        ]);

        Pattern::create([
            'user_id' => $amina->id,
            'title' => 'Emerald Diamond',
            'symmetry_type' => '4-fold',
            'base_shape' => 'diamond',
            'colors' => ['#047857', '#f0fdf4', '#d1fae5'],
            'grid_density' => 6,
            'is_public' => true,
            'is_featured' => false,
            'likes_count' => 7,
        ]);

        Pattern::create([
            'user_id' => $oussama->id,
            'title' => 'Golden Knot',
            'symmetry_type' => '6-fold',
            'base_shape' => 'knot',
            'colors' => ['#d97706', '#fef3c7', '#78350f'],
            'grid_density' => 10,
            'is_public' => true,
            'is_featured' => true,
            'likes_count' => 18,
        ]);

        Pattern::create([
            'user_id' => $amina->id,
            'title' => 'Floral Mosaic',
            'symmetry_type' => '8-fold',
            'base_shape' => 'floral',
            'colors' => ['#be185d', '#fce7f3', '#831843'],
            'grid_density' => 12,
            'is_public' => true,
            'is_featured' => false,
            'likes_count' => 5,
        ]);

        Pattern::create([
            'user_id' => $admin->id,
            'title' => 'Rasma Dyali Classic',
            'symmetry_type' => '4-fold',
            'base_shape' => 'star',
            'colors' => ['#111827', '#f59e0b', '#ffffff'],
            'grid_density' => 8,
            'is_public' => true,
            'is_featured' => true,
            'likes_count' => 25,
        ]);
    }
}