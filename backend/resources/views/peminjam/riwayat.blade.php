<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Peminjaman - Panel Peminjam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8f9fa; }
        .sidebar { width: 250px; height: 100vh; position: fixed; top: 0; left: 0; background-color: #1a222f; color: #fff; display: flex; flex-direction: column; justify-content: space-between; }
        .sidebar .brand { padding: 20px; font-size: 1.2rem; font-weight: bold; letter-spacing: 1px; }
        .sidebar .nav-link { color: #a0aec0; padding: 12px 20px; display: block; text-decoration: none; }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: #fff; background-color: #242f3d; }
        .sidebar .user-footer { padding: 15px 20px; font-size: 0.85rem; color: #a0aec0; border-top: 1px solid #2d3748; }
        .main-content { margin-left: 250px; padding: 20px 30px; }
        .card-custom { background: #fff; border-radius: 8px; border: 1px solid #e2e8f0; padding: 24px; }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div>
            <div class="brand">PANEL PEMINJAM</div>
            <nav class="mt-3">
                <a href="{{ route('peminjam.katalog') }}" class="nav-link {{ request()->routeIs('peminjam.katalog') ? 'active' : '' }}">Katalog Alat</a>
                <a href="{{ route('peminjam.riwayat') }}" class="nav-link {{ request()->routeIs('peminjam.riwayat') ? 'active' : '' }}">Riwayat Pinjam</a>
            </nav>
        </div>
        <div class="user-footer">
            Logged in as: <strong>{{ Auth::user()->name ?? 'Peminjam' }}</strong>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold m-0">Riwayat Peminjaman</h4>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm px-3 fw-bold">Logout</button>
            </form>
        </div>

        @if (session('success'))
            <div class="alert alert-success mb-3">
                {{ session('success') }}
            </div>
        @endif

        <div class="card-custom">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal Pinjam</th>
                            <th>Rencana Kembali</th>
                            <th>Status</th>
                            <th>Detail Alat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($peminjamans as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tgl_pinjam)->format('Y-m-d') }}</td>
                                <td>{{ $item->tgl_kembali_pinjam ?? '-' }}</td>
                                <td>
                                    <span class="badge bg-{{ $item->status == 'disetujui' ? 'success' : ($item->status == 'diajukan' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>
                                <td>
                                    <ul class="mb-0 ps-3">
                                        @foreach ($item->detailPinjams as $detail)
                                            <li>{{ $detail->alat->nama_alat ?? 'Alat' }} ({{ $detail->jumlah }} unit)</li>
                                        @endforeach
                                    </ul>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">Belum ada riwayat peminjaman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>