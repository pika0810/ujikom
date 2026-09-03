<?php

namespace Database\Seeders;

use App\Models\Pengembalian;
use Illuminate\Database\Seeder;

class PengembalianSeeder extends Seeder
{
    public function run(): void
    {
        $pengembalian = [
            [
                'peminjaman_id' => 1,
                'tgl_kembali' => '2026-06-04',
                'kondisi_kembali' => 'Lengkap dan Berfungsi Baik',
                'denda' => 0,
                'petugas_id' => 2, //Arif (petugas)
            ],
            [
                'peminjaman_id' => 2,
                'tgl_kembali' => '2026-06-05',
                'kondisi_kembali' => 'Lengkap dan Berfungsi Baik',
                'denda' => 0,
                'petugas_id' => 2,
            ],
            [
                'peminjaman_id' => 3,
                'tgl_kembali' => '2026-06-09',//telat 3 hari dr tgl 6
                'kondisi_kembali' => 'Lengkap, Casing Sedikit Tergores',
                'denda' => 30000, // asumsi denda per hari 10 rb
                'petugas_id' => 2,
            ],
        ];

        foreach ($pengembalian as $kembali) {
            Pengembalian::create($kembali);
        }
    }
}
