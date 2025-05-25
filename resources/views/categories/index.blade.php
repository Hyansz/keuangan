@extends('layout')

@section('topbar')
    <div class="d-flex align-items-center justify-content-between flex-wrap bg-white mb-4 static-top p-4 shadow">
        <h1 class="h3 mb-0 text-gray-800">Kategori</h1>
        <div class="d-flex align-items-center gap-2">
            {{-- <a href="#" class="btn btn-sm btn-primary shadow-sm mt-2 mt-sm-0" data-bs-toggle="modal" data-bs-target="#modalCetak">
                <i class="fas fa-download fa-sm text-white-50"></i> Cetak
            </a> --}}

            <div class="dropdown">
                <button class="btn btn-sm dropdown-toggle d-flex align-items-center gap-2" 
                    type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ Auth::user()->avatar ?? asset('img/default_avatar.png') }}" alt="avatar" 
                        class="rounded-circle" width="32" height="32" style="object-fit: cover;">
                    <span>{{ Auth::user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                    {{-- <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a></li> --}}
                    {{-- <li><hr class="dropdown-divider"></li> --}}
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger fw-bold">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Modal Cetak -->
    {{-- <div class="modal fade" id="modalCetak" tabindex="-1" aria-labelledby="modalCetakLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('cetak.laporan') }}" method="GET" target="_blank">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCetakLabel">Cetak Laporan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="bulan" class="form-label">Bulan</label>
                            <select class="form-control" name="bulan" id="bulan">
                                <option value="">-- Semua Bulan --</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ DateTime::createFromFormat('!m', $i)->format('F') }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tahun" class="form-label">Tahun</label>
                            <select class="form-control" name="tahun" id="tahun">
                                @for ($i = date('Y'); $i >= 2020; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Cetak</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div> --}}
@endsection

@section('tambah')
    <!-- Tombol untuk membuka modal -->
    <div class="card h-100 text-decoration-none shadow" id="openModal" style="cursor: pointer;">
        <div class="card h-100 py-2 bg-primary border-primary shadow">
            <div class="card-body bg-primary text-white d-flex justify-content-center align-items-center">
                <p class="mb-0 fw-bold">Tambah Kategori</p>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="modalTambah" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Tambah Kategori</h2>
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Kategori</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label">Jenis</label>
                    <select name="type" id="type" class="form-control" required>
                        <option value="pemasukan">Pemasukan</option>
                        <option value="pengeluaran">Pengeluaran</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>

    <style>
        .panah{
            -moz-appearance: textfield;
        }

        .panah::-webkit-outer-spin-button,
        .panah::-webkit-inner-spin-button {
            margin: 0;
            -webkit-appearance: none;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            padding: 20px;
            border-radius: 10px;
            width: 400px;
            position: relative;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 20px;
            cursor: pointer;
        }
    </style>

    <script>
        document.getElementById('openModal').addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah redirect ke halaman tambah
            document.getElementById('modalTambah').style.display = 'flex';
        });

        document.querySelector('.close').addEventListener('click', function() {
            document.getElementById('modalTambah').style.display = 'none';
        });

        window.onclick = function(event) {
            if (event.target == document.getElementById('modalTambah')) {
                document.getElementById('modalTambah').style.display = 'none';
            }
        };
    </script>
@endsection

@section('content1')
    <style>
        /* Atur lebar kolom Nama dan Aksi di desktop */
        @media (min-width: 992px) { /* breakpoint lg bootstrap */
            table.table thead th:first-child,
            table.table tbody td:first-child {
            width: 70%; /* Nama lebar besar */
            }
            table.table thead th:last-child,
            table.table tbody td:last-child {
            width: 30%; /* Aksi kecil */
            text-align: center !important; /* Tengah-tengah horizontal */
            vertical-align: middle !important;
            }
        }
    </style>

    <div class="container p-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="py-2 m-0">Kategori Pemasukan</h4>
            <button class="btn btn-sm btn-primary" onclick="openModal('pemasukan')">Tambah</button>
        </div>
        <div class="table-responsive">
            <table class="table table-striped mt-3 align-middle">
                <thead>
                    <tr>
                    <th>Nama</th>
                    <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories->where('type', 'pemasukan')->sortByDesc('created_at')->values() as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td class="text-center">
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm me-1">Edit</a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline m-0 p-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('content2')
    <div class="container p-3">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="py-2 m-0">Kategori Pengeluaran</h4>
            <button class="btn btn-sm btn-primary" onclick="openModal('pengeluaran')">Tambah</button>
        </div>
        <div class="table-responsive">
            <table class="table table-striped mt-3 align-middle">
                <thead>
                    <tr>
                    <th>Nama</th>
                    <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories->where('type', 'pengeluaran')->sortByDesc('created_at')->values() as $category)
                    <tr>
                        <td>{{ $category->name }}</td>
                        <td class="text-center">
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm me-1">Edit</a>
                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" class="d-inline m-0 p-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
