<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use LaravelEasyRepository\Traits\GenUid2;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'id'        => '',
            'Nama'      => 'Administrator',
            'username'     => 'admin@gmail.com',
            'levelakses'     => '1',
            'password'  => Hash::make('admin'),
        ]);

    }
}