<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Carbon\Carbon;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->delete();
        $roles = [
            [
                'id' => 1,
                'role' => 'admin',
                'description' => 'Administrator Website'
            ],
            [
                'id' => 2,
                'role' => 'user',
                'description' => 'User biasa'
            ],
        ];
        DB::table('roles')->insert($roles);
    }
}
