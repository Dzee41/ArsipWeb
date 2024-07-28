<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->delete();
        $input = [
            [
                'id'        => 1,
                'name'      => 'Admin',
                'email'     => 'admin@mail.com',
                'address'   => 'Planet Lain',
                'photo'     => null,
                'role_id'   => 1,
                'is_active' => true,
                'password'  => Hash::make('admin123!')
            ],
            [
                'id'        => 2,
                'name'      => 'User',
                'email'     => 'user@mail.com',
                'address'   => 'Planet Lain',
                'photo'     => null,
                'role_id'   => 2,
                'is_active' => false,
                'password'  => Hash::make('user123!')
            ],
        ];
        DB::table('users')->insert($input);
    }
}
