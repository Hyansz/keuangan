@extends('layout')

@section('income')
    <div class="card border-left-success bg-success shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-white text-uppercase mb-1">
                        Total Pemasukan</div>
                    <div class="h5 mb-0 font-weight-bold text-white">
                        Rp {{ number_format($b, 0, ',', '.') }}
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fa-solid fa-arrow-trend-up fa-2x text-white"></i> 
                </div>
            </div>
        </div>
    </div>
@endsection

@section('expend')
    <div class="card border-left-danger bg-danger shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-white text-uppercase mb-1">
                        Total Pengeluaran</div>
                    <div class="h5 mb-0 font-weight-bold text-white">
                        Rp {{ number_format($c, 0, ',', '.') }}
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fa-solid fa-arrow-trend-down fa-2x text-white"></i>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('rest')
    <div class="card border-left-warning bg-warning shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-white text-uppercase mb-1">
                        Sisa</div>
                    <div class="h5 mb-0 font-weight-bold text-white">
                        Rp {{ number_format($b - $c, 0, ',', '.') }}
                    </div>
                </div>
                <div class="col-auto">
                    <i class="fa-solid fa-coins fa-2x text-white"></i>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pengeluaran')
    <div class="col mr-2">
        <div class="text-xs font-weight-bold text-white text-uppercase mb-1">
            Total Pengeluaran</div>
        <div class="h5 mb-0 font-weight-bold text-white">
            Rp {{ number_format($c, 0, ',', '.') }}
        </div>
    </div>
    <div class="col-auto">
        <i class="fa-solid fa-arrow-trend-down fa-2x text-white"></i>
    </div>
@endsection

@section('tambah')
    <!-- Tombol untuk membuka modal -->
    <div class="card h-100 text-decoration-none shadow" id="openModal" style="cursor: pointer;">
        <div class="card h-100 py-2 bg-primary border-primary shadow">
            <div class="card-body bg-primary text-white d-flex justify-content-center align-items-center">
                <p class="mb-0 fw-bold">Tambah Aktivitas</p>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div id="modalTambah" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h4 class="py-2">Tambah Aktivitas</h4>
            <form action="{{ route('pages.submit') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <input type="number" name="nominal" class="form-control text-black panah" placeholder="Nominal" required>
                </div>
                <div class="mb-3 d-flex gap-3 justify-content-center">
                    <label>
                        <input type="radio" name="tipe" value="pemasukan" onchange="updateKategori()" required> Pemasukan
                    </label>
                    <label>
                        <input type="radio" name="tipe" value="pengeluaran" onchange="updateKategori()" required> Pengeluaran
                    </label>
                </div>        
                <div class="mb-3 pl-1">
                    <label for="kategori_id">Kategori:</label>
                    <select name="kategori_id" id="kategori_id" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>   
                </div>
                <div class="mb-3">
                    <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                </div>
                <div class="mb-3">
                    <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" placeholder="Deskripsi"></textarea>
                </div>
                <button class="btn btn-primary">Tambah</button>
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

@section('content3')
    <div class="container py-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h2 class="mb-0">Edit Aktivitas</h2>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">X</a>
        </div>
        <form action="{{ route('pages.update', $a->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <!-- Kolom untuk Nominal dan Jenis -->
                <div class="col-12 col-md-6 mb-3">
                    <label for="nominal" class="form-label">Nominal</label>
                    <input type="number" name="nominal" id="nominal" class="form-control panah" value="{{ old('nominal', $a->pemasukan ?? $a->pengeluaran) }}" required>
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <label for="tipe" class="form-label">Jenis</label>
                    <select name="tipe" id="tipe" class="form-control" required>
                        <option value="pemasukan" {{ $a->tipe == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                        <option value="pengeluaran" {{ $a->tipe == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                    </select>
                </div>

                <!-- Kolom untuk Kategori dan Tanggal -->
                <div class="col-12 col-md-6 mb-3">
                    <label for="kategori_id" class="form-label">Kategori</label>
                    <select name="kategori_id" id="kategori_id" class="form-control" required>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->id == $a->kategori_id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 col-md-6 mb-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $a->tanggal }}" required>
                </div>
            </div>

            <!-- Deskripsi -->
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4" placeholder="Deskripsi">{{ $a->deskripsi }}</textarea>
            </div>

            <!-- Tombol Update dan Kembali -->
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection
