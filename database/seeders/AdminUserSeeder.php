<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

final class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@autoblog.com'],
            [
                'name' => 'admin',
                'password' => \Illuminate\Support\Facades\Hash::make('password'),
            ]
        );
    }
}
