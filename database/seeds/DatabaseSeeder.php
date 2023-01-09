<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\User::insert([
            'name' => 'admin',
            'role' => 'admin',
            'company' => 'AIIA',
            'email' => 'administrator@aiia.co.id',
            'password' => \Illuminate\Support\Facades\Hash::make('12345678')
        ]);
    }
}