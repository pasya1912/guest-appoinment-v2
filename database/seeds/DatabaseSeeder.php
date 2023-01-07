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
            'name' => 'fabian',
            'role' => 'admin',
            'company' => 'AIIA',
            'email' => 'fabian@aiia.co.id',
            'password' => \Illuminate\Support\Facades\Hash::make('akurakreti')
        ]);
    }
}