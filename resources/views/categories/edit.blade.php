@extends('layout')

@section('pemasukan')
    <div class="col mr-2">
        <div class="text-xs font-weight-bold text-white text-uppercase mb-1">
            Total Pemasukan</div>
        <div class="h5 mb-0 font-weight-bold text-white">
            Rp {{ number_format($b - $c, 0, ',', '.') }}
        </div>
    </div>
    <div class="col-auto">
        <i class="fa-solid fa-arrow-trend-up fa-2x text-white"></i> 
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
                    <input type="number" name="pemasukan" class="form-control text-black panah" placeholder="Pemasukan">
                </div>
                <div class="mb-3">
                    <input type="number" name="pengeluaran" class="form-control text-black panah" placeholder="Pengeluaran">
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
            <h2 class="mb-0">Edit Kategori</h2>
            <a href="{{ url()->previous() }}" class="btn btn-secondary">X</a>
        </div>
        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <!-- Kolom untuk Nama Kategori -->
                <div class="col-12 mb-3">
                    <label for="name" class="form-label">Nama Kategori</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $category->name }}" required>
                </div>

                <!-- Kolom untuk Jenis -->
                <div class="col-12 mb-3">
                    <label for="type" class="form-label">Jenis</label>
                    <select name="type" id="type" class="form-control" required>
                        <option value="pemasukan" {{ $category->type == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                        <option value="pengeluaran" {{ $category->type == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                    </select>
                </div>
            </div>

            <!-- Tombol Update -->
            <div class="d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">Update</button>
            </div>
        </form>
    </div>
@endsection
