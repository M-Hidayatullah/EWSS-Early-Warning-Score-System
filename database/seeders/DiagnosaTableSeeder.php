<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DiagnosaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('diagnosa')->insert([
            [
               'nama' => 'admin',
               'alamat'=> 'lombok tengah',
               'usia'=> '20',
               'tingkat_kesadaran' => 'apatis',
               'pernafasan' => '30',
               'denyut_nadi' => '80',
               'tekanan_darah' =>'23',
               'suhu' => '10',
               'hasil' => 2,
               'keterangan_hasil' => "Pengkajian ulang harus dilakukan oleh perawat Primer / PJ Shift.",
               'created_at' => date("Y-m-d H:i:s"),
               'updated_at' => date("Y-m-d H:i:s"),
            ],
            [
                'nama' => 'dayat',
                'alamat'=> 'lombok barat',
                'usia'=> '70',
                'tingkat_kesadaran' => 'apatis',
                'pernafasan' => '30',
                'denyut_nadi' => '80',
                'tekanan_darah' =>'23',
                'suhu' => '10',
                'hasil' => 2,
                'keterangan_hasil' => "Pengkajian ulang harus dilakukan oleh perawat Primer / PJ Shift.",
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
             ]
        ]);
    }
}
