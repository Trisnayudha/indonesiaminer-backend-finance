<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Data Admin
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@indonesiaminer.com',
            'password' => Hash::make('12345678'), // Hash password
            'level' => 'Administration',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
