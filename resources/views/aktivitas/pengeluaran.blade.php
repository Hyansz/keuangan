@extends('layout')

@section('topbar')
    <div class="d-flex align-items-center justify-content-between flex-wrap bg-white mb-4 static-top p-4 shadow">
        <h1 class="h3 mb-0 text-gray-800">Aktivitas Pengeluaran</h1>
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

    {{-- <!-- Modal Cetak -->
    <div class="modal fade" id="modalCetak" tabindex="-1" aria-labelledby="modalCetakLabel" aria-hidden="true">
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

@section('content3')
    <style>
        .table-bordered {
            border: 1px solid #dee2e6;
        }

        .table-bordered th,
        .table-bordered td {
            border: 1px solid #dee2e6;
        }

        .table thead th {
            background-color: #f1f5ff;
        }

        .table tbody tr:hover {
            background-color: #f8fbff;
        }
    </style>

    <div class="container px-4 py-4">
        <div class="bg-white p-4 rounded-4 shadow-sm">

            <form method="GET" action="{{ route('aktivitas.pengeluaran') }}" class="row g-3 mb-4">
                <div class="col-md-4">
                    <label for="kategori" class="form-label">Kategori</label>
                    <select class="form-select" name="kategori" id="kategori">
                        <option value="">-- Semua Kategori --</option>
                        @foreach ($daftarKategori as $kategori)
                            <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="bulan" class="form-label">Bulan</label>
                    <select class="form-select" name="bulan" id="bulan">
                        <option value="">-- Semua Bulan --</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option value="{{ $i }}" {{ request('bulan') == $i ? 'selected' : '' }}>
                                {{ DateTime::createFromFormat('!m', $i)->format('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="tahun" class="form-label">Tahun</label>
                    <select class="form-select" name="tahun" id="tahun">
                        @for ($i = date('Y'); $i >= 2025; $i--)
                            <option value="{{ $i }}" {{ request('tahun') == $i ? 'selected' : '' }}>
                                {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered align-middle" style="border-radius: 12px; overflow: hidden;">
                    <thead class="text-center text-uppercase" style="background: #f1f5ff;">
                        <tr>
                            <th class="fw-semibold">Tanggal</th>
                            <th class="fw-semibold">Kategori</th>
                            <th class="fw-semibold">Nominal</th>
                            <th class="fw-semibold">Deskripsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pengeluaran as $item)
                            <tr class="text-center">
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                                <td>{{ $item->kategori->name }}</td>
                                <td class="text-danger fw-semibold">Rp {{ number_format($item->pengeluaran, 0, ',', '.') }}</td>
                                <td>{{ $item->deskripsi }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">Belum ada data pengeluaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
