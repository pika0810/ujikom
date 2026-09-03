<?php

namespace Database\Seeders;

use App\Models\DetailPinjam;
use Illuminate\Database\Seeder;

class DetailPinjamSeeder extends Seeder
{
    public function run(): void
    {
        $details = [
            ['peminjaman_id' => 1, 'alat_id' => 1, 'jumlah' => 2], // pinjam 2 mikrotik
            ['peminjaman_id' => 2, 'alat_id' => 2, 'jumlah' => 1], // pinjam 1 kamera
            ['peminjaman_id' => 3, 'alat_id' => 3, 'jumlah' => 1], // pinjam 1 mini pc
            ['peminjaman_id' => 4, 'alat_id' => 2, 'jumlah' => 2], // pinjam 2 tang crimping
            ['peminjaman_id' => 5, 'alat_id' => 5, 'jumlah' => 3], // pinjam 3 adapter
        ];
        
        foreach ($details as $detail) {
            DetailPinjam::create($detail);
        }
    }
}
