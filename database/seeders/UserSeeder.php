<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //data dami/sementara/uji coba meniympan data ke db tanpa menggunakan formulir

        User::create([
            "name"=> "Admin",
            "email"=> "Admin@example.com",
            "password"=> bcrypt("admin123"),
            "role"=> "Admin",
        ]);

        User::create([
            "name"=> "User",
            "email"=> "User@example.com",
            "password"=> bcrypt("user123"),
            "role"=> "User",
        ]);

        User::create([
            "name"=> "Kasir1",
            "email"=> "kasir@example.com",
            "password"=> bcrypt("kasir123"),
            "role"=> "kasir",
        ]);

        User::create([
            "name"=> "Kasir2",
            "email"=> "kasir2@example.com",
            "password"=> bcrypt("kasir1234"),
            "role"=> "kasir",
        ]);
    }
}
