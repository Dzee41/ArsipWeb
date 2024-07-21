<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->delete();
        $categories = [
            [
                'id' => 1,
                'category_name' => 'Dokumen Legal',
                'used_for'      => "- Kontrak\n- Perjanjian\n- Sertifikat",
                'tab_routes'    => 'dokumen_legal',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'id' => 2,
                'category_name' => 'Dokumen Penelitian',
                'used_for'      => "- Hasil Penelitian\n- Data Eksperimen\n- Makalah Ilmiah\n- Laporan Lab",
                'tab_routes'    => 'documen_penelitian',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'id' => 3,
                'category_name' => 'Dokumen Administratif',
                'used_for'      => "- Surat Menyurat\n- Notulen Rapat\n- Surat Kebijakan",
                'tab_routes'    => 'dokumen_administratif',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
            [
                'id' => 4,
                'category_name' => 'Dokumen Lainnya',
                'used_for'      => "- Arsip Pribadi\n- Foto atau Video\n- Dokumen Sejarah\n- Arsip Multimedia",
                'tab_routes'    => 'dokumen_lainnya',
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now()
            ],
        ];
        DB::table('categories')->insert($categories);
    }
}
