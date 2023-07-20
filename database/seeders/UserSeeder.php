<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Darwin Samijon',
                'email' => 'darwin@gmail.com',
                'password' => Hash::make('666')
            ],
            [
                'name' => 'Wendy Samijon',
                'email' => 'wendy@gmail.com',
                'password' => Hash::make('666')
            ],
            [
                'name' => 'Gaw Honda',
                'email' => 'gaw@gmail.com',
                'password' => Hash::make('666')
            ]
        ]);
    }
}
