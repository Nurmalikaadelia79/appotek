<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use  Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::Create([
            'name' => 'Administrator' ,
            'email' => 'adminapotek@gmail.com' ,
            'role' => 'admin' ,
            'password' => Hash::make('admin123')
        ]);
        User::Create([
            'name' => 'Kasir 1' ,
            'email' => 'kasirapotek@gmail.com' ,
            'role' => 'kasir' ,
            'password' => Hash::make('kasir123')
        ]);
    }
}
