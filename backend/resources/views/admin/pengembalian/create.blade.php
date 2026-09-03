@extends('layouts.app')
@section('title', 'Manajemen Transaksi Pengembalian - Panel Admin')
@section('header-title', 'Manajemen Transaksi Pengembalian')

@section('content')
<div class="max-w-xl bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="p-6 border-b border-gray-100">
        <h2 class="text-lg font-bold text-gray-800">Proses Pengembalian Alat</h2>
    </div>

    <div class="p-6">
        @if(session('error'))
            <div class="mb-4 bg-red-50 border border-red-200 text-red-800 p-3 rounded-lg text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.pengembalian.store') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Pilih Transaksi Peminjaman</label>
                <select name="peminjaman_id" required class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    <option value="">-- Pilih Transaksi Peminjaman --</option>
                    @foreach($peminjamans as $pinjam)
                        <option value="{{ $pinjam->id }}">
                            {{ $pinjam->user->name ?? 'User' }} - 
                            [Alat: @foreach($pinjam->detailPinjam as $d) {{ $d->alat->nama_alat ?? '' }} ({{ $d->jumlah }}pcs) @endforeach]
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Tanggal Dikembalikan</label>
                <input type="date" name="tgl_kembali" value="{{ date('Y-m-d') }}" required 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Kondisi Alat Saat Kembali</label>
                <input type="text" name="kondisi_kembali" value="Lengkap dan Berfungsi Baik" required 
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Denda Total (Rp) - Manual</label>
                <input type="number" name="denda_manual" min="0" placeholder="Kosongkan jika ingin dihitung otomatis"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-semibold mb-2">Tarif Denda Harian (Rp / Hari)</label>
                <input type="number" name="tarif_harian" value="1000" min="0" required
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
            </div>

            <div class="flex items-center space-x-2">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2 rounded-lg text-sm font-semibold transition">Simpan Pengembalian</button>
                <a href="{{ route('admin.pengembalian.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-5 py-2 rounded-lg text-sm font-semibold transition">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection