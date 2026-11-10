<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Alat - Panel Peminjam</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #1a222f;
            color: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .sidebar .brand {
            padding: 20px;
            font-size: 1.2rem;
            font-weight: bold;
            letter-spacing: 1px;
            text-transform: uppercase;
        }
        .sidebar .nav-link {
            color: #a0aec0;
            padding: 12px 20px;
            display: block;
            text-decoration: none;
            transition: 0.2s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            color: #fff;
            background-color: #242f3d;
        }
        .sidebar .user-footer {
            padding: 15px 20px;
            font-size: 0.85rem;
            color: #a0aec0;
            border-top: 1px solid #2d3748;
        }
        
        /* Main Content Styling */
        .main-content {
            margin-left: 250px;
            padding: 20px 30px;
        }
        .top-navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        .card-custom {
            background: #fff;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }
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

    <!-- MAIN CONTENT AREA -->
    <div class="main-content">
        <!-- TOP NAVBAR / HEADER -->
        <div class="top-navbar">
            <h4 class="fw-bold m-0">Katalog Alat Tersedia</h4>
            <form action="{{ route('logout') }}" method="POST" class="m-0">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm px-3 fw-bold">Logout</button>
            </form>
        </div>

        <!-- NOTIFIKASI ERROR JIKA VALIDASI GAGAL -->
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- FORM & TABLE CONTENT -->
        <div class="card-custom">
            <form action="{{ route('peminjam.peminjaman.ajukan') }}" method="POST">
                @csrf
                
                <!-- Input Rencana Tanggal Kembali -->
                <div class="mb-4">
                    <label for="tgl_kembali_pinjam" class="form-label fw-semibold text-secondary">Rencana Tanggal Kembali</label>
                    <input type="date" id="tgl_kembali_pinjam" name="tgl_kembali_pinjam" class="form-control" style="max-width: 400px;" required>
                </div>

                <!-- Tabel Data Alat -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50px;">Pilih</th>
                                <th>Nama Alat</th>
                                <th>Kategori</th>
                                <th>Stok Tersedia</th>
                                <th style="width: 150px;">Jumlah Pinjam</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($alats as $alat)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" name="alat_id[]" value="{{ $alat->id }}" class="form-check-input">
                                    </td>
                                    <td class="fw-medium">{{ $alat->nama_alat }}</td>
                                    <td>{{ $alat->kategori->nama_kategori ?? '-' }}</td>
                                    <td>{{ $alat->stok }}</td>
                                    <td>
                                        <input type="number" name="jumlah[]" value="1" min="1" max="{{ $alat->stok }}" class="form-control form-control-sm">
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">Belum ada alat tersedia di katalog.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Tombol Submit -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary px-4 fw-semibold">Ajukan Peminjaman</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>