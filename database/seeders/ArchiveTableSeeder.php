<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ArchiveTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('archives')->delete();
        $arvhives = [
            [
                'id'    => 1,
                'title' => 'Dokument Perjanjian Majapahit',
                'description'   => 'Untuk keperluan berkas dengan kerjaan singosari',
                'file'          => '',
                'category_id'   => 1,
                'user_id'       => 1,
                'created_at'    => Carbon::now('Asia/Jakarta'),
                'updated_at'    => Carbon::now('Asia/Jakarta')
            ],
            [
                'id'    => 2,
                'title' => 'Dokument Perjanjian Kutay',
                'description'   => 'Untuk keperluan berkas dengan kerjaan Kutay',
                'file'          => '',
                'category_id'   => 1,
                'user_id'       => 1,
                'created_at'    => Carbon::now('Asia/Jakarta'),
                'updated_at'    => Carbon::now('Asia/Jakarta')
            ],
            [
                'id'    => 3,
                'title' => 'Dokument Perjanjian Raja Raja',
                'description'   => 'Untuk keperluan berkas dengan kerjaan Kutay',
                'file'          => '',
                'category_id'   => 2,
                'user_id'       => 1,
                'created_at'    => Carbon::now('Asia/Jakarta'),
                'updated_at'    => Carbon::now('Asia/Jakarta')
            ],
        ];
        DB::table('archives')->insert($arvhives);
    }
}
