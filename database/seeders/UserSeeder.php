<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nama' => 'Admin',
            'email' => 'admin@tiketing.id',
            'password' => bcrypt('12345678'),
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Admin',
            'role' => 'admin',
        ]);

        User::create([
            'nama' => 'User',
            'email' => 'user@tiketing.id',
            'password' => bcrypt('12345678'),
            'no_hp' => '081234567890',
            'alamat' => 'Jl. User',
            'role' => 'user',
        ]);
    }
}
